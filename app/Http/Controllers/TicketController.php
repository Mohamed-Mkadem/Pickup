<?php

namespace App\Http\Controllers;

use App\Events\TicketClosed;
use App\Events\TicketResponseCreated;
use App\Events\TicketSubmitted;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    protected $messages = [
        'file.max' => 'The Maximum File Size is 5 MB',
        'file.size' => 'The Maximum File Size is 5 MB',
    ];
    /**
     * Display a listing of the resource.
     */

    public function filter(Request $request)
    {
        $user = Auth::user();

        $query = Ticket::query();
        if ($user->type != 'Admin') {
            $query->where('user_id', $user->id);
        }
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $statuses = $request->status ?? [];
        $user_types = $request->user_types ?? [];

        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }
        if (!empty($user_types)) {
            $query->whereHas('user', function ($subQuery) use ($user_types) {
                $subQuery->whereIn('type', $user_types);
            });
        }

        if (!empty($search)) {
            $query->where('id', 'like', "%$search%");
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');

        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tickets = $query->paginate();
        if ($user->type == 'Client') {
            return view('Client.Tickets.client-tickets-index', ['tickets' => $tickets]);
        }

        if ($user->type == 'Seller') {
            return view('Seller.Tickets.seller-tickets-index', ['tickets' => $tickets]);
        }
        $statistics = $this->calculateStatistics();
        $tickets = $query->with('user')->paginate();
        return view("Admin.Tickets.tickets-index", ['tickets' => $tickets, 'statistics' => $statistics]);
    }
    public function index()
    {
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate();

        if ($user->type == 'Client') {
            return view('Client.Tickets.client-tickets-index', ['tickets' => $tickets]);
        }

        if ($user->type == 'Seller') {
            return view('Seller.Tickets.seller-tickets-index', ['tickets' => $tickets]);
        }
        $statistics = $this->calculateStatistics();
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->paginate();
        return view("Admin.Tickets.tickets-index", ['tickets' => $tickets, 'statistics' => $statistics]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->type == 'Client') {
            return view('Client.Tickets.client-tickets-create');
        }
        return view('Seller.Tickets.seller-tickets-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string', 'max:1500'],
            'file' => ['file', 'mimes:zip,rar,jpg,jpeg,png,pdf', 'max:5120'],
        ], $this->messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $path = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $name = time() . '_' . $originalName;
            $path = $file->storeAs('attachments', $name, [
                'disk' => 'public',
            ]);
            $originalSize = floor($file->getSize() / 1000);

            $size = $originalSize . ' KB';
            if ($originalSize > 1000) {
                $size = floor($originalSize / 1000) . ' MB';
            }

        }

        try {
            DB::beginTransaction();
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            if ($path) {
                $ticket->attachments()->create([
                    'name' => $originalName,
                    'path' => $path,
                    'size' => $size,
                ]);
            }
            DB::commit();

            event(new TicketSubmitted($ticket));
            return redirect()->back()->with('success', 'Ticket Submitted Successfully');

            // Event to inform the admin
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['statusHistories', 'attachments', 'user', 'responses', 'responses.user'])->findOrFail($id);
        // dd($ticket->responses);
        $this->authorize('view', $ticket);

        if (Auth::user()->type == 'Client') {
            return view('Client.Tickets.client-tickets-show', ['ticket' => $ticket]);
        }
        if (Auth::user()->type == 'Seller') {
            return view('Seller.Tickets.seller-tickets-show', ['ticket' => $ticket]);
        }

        return view('Admin.Tickets.tickets-show', ['ticket' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function response(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->status == 'closed') {
            return redirect()->back()->with('error', 'Cannot add a response to a closed ticket');
        }
        $user = Auth::user();
        $validation = Validator::make($request->all(), [
            'message' => ['required', 'string', 'max:1500'],
            'file' => ['file', 'mimes:zip,rar,jpg,jpeg,png,pdf', 'max:5120', 'nullable'],
        ], $this->messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $path = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $name = time() . '_' . $originalName;
            $path = $file->storeAs('attachments', $name, [
                'disk' => 'public',
            ]);
            $originalSize = floor($file->getSize() / 1000);

            $size = $originalSize . ' KB';
            if ($originalSize > 1000) {
                $size = floor($originalSize / 1000) . ' MB';
            }

        }

        try {
            DB::beginTransaction();
            $ticket->update([
                'status' => 'in progress',
            ]);
            $ticket->responses()->create([
                'user_id' => $user->id,
                'message' => $request->message,
            ]);

            if ($path) {
                $ticket->attachments()->create([
                    'name' => $originalName,
                    'path' => $path,
                    'size' => $size,
                ]);
            }
            DB::commit();
            // Event to inform the other side
            event(new TicketResponseCreated($user, $ticket));
            return redirect()->back()->with('success', 'Response Submitted Successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('update', $ticket);
        $user = Auth::user();
        if ($ticket->status == 'closed') {
            return redirect()->back()->with('error', 'This Ticket is Already Closed');

        }

        try {

            $ticket->update([
                'status' => 'closed',
            ]);
            event(new TicketClosed($user, $ticket));
            return redirect()->back()->with('success', 'Ticket Closed Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went Wrong');
            // throw $th;
        }
    }

    private function calculateStatistics()
    {

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
// Get the counts for each status in all time
        $counts = [

            'total' => Ticket::count(),
            'new' => Ticket::where('status', 'new')->count(),
            'in progress' => Ticket::where('status', 'in progress')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];
// Get the counts for each status in the current month
        $currentMonthCounts = [
            'total' => Ticket::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count(),
            'new' => Ticket::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'new')->count(),
            'in progress' => Ticket::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'in progress')->count(),
            'closed' => Ticket::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'closed')->count(),
        ];

// Get the counts for each status in the previous month
        $previousMonthCounts = [
            'total' => Ticket::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count(),
            'new' => Ticket::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'new')->count(),
            'in progress' => Ticket::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'in progress')->count(),
            'closed' => Ticket::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'closed')->count(),
        ];

// Calculate the difference for each status
        $difference = [
            'total' => $currentMonthCounts['total'] - $previousMonthCounts['total'],
            'new' => $currentMonthCounts['new'] - $previousMonthCounts['new'],
            'in progress' => $currentMonthCounts['in progress'] - $previousMonthCounts['in progress'],
            'closed' => $currentMonthCounts['closed'] - $previousMonthCounts['closed'],
        ];

        return compact('counts', 'difference', 'previousMonthCounts', 'currentMonthCounts');
    }
}
