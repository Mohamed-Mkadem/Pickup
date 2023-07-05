<?php

namespace App\Http\Controllers;

use App\Events\PaymentRequestAccepted;
use App\Events\PaymentRequestCreated;
use App\Events\PaymentRequestRejected;
use App\Models\PaymentRequest;
use App\Models\Seller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentRequestController extends Controller
{
    public $attributes = [
        'amount.max' => 'Insufficient Balance',
        'amount.min' => 'The Mininmum Amount To Withdraw is 10 TND',
    ];
    /**
     * Display a listing of the resource.
     */

    public function adminIndex()
    {
        // // dd(Carbon::now()->subDays(3));
        // $paymentRequests = PaymentRequest::where('status', 'accepted')
        //     ->whereDate('updated_at', '<=', Carbon::now()->subDays(3))
        //     ->get();
        // // dd($paymentRequests);
        $paymentRequests = PaymentRequest::with('seller.user')->orderBY('created_at', 'desc')->paginate();

        return view('Admin.Payments.payments-index', ['payments' => $paymentRequests, 'statistics' => $this->calculateStatistics()]);
    }
    public function index()
    {
        $seller = Seller::where('user_id', Auth::id())->first();

        $paymentRequests = PaymentRequest::where('seller_id', Auth::user()->seller->id)->with(['statusHistories'])->orderBY('created_at', 'desc')->paginate();
        return view('Seller.Payments.seller-payments-index', ['payments' => $paymentRequests]);
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = PaymentRequest::query();
        if ($user->type == 'Seller') {
            $query->where('seller_id', $user->seller->id);
        }
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? [];
        $sort = $request->sort ?? 'newest';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';

        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $query->where('created_at', '<=', $maxDate);
        }

        if (!empty($search)) {
            $query->where('id', 'like', "%$search%");
        }

        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        if (!empty($minAmount)) {
            $query->where('amount', '>=', $minAmount);
        }
        if (!empty($maxAmount)) {
            $query->where('amount', '<=', $maxAmount);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'highest amount') {
            $query->orderBy('amount', 'desc');
        } elseif ($sort === 'lowest amount') {
            $query->orderBy('amount', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $paymentRequests = $query->with('seller')->paginate();
        if ($user->type == 'Seller') {
            return view('Seller.Payments.seller-payments-index', ['payments' => $paymentRequests]);
        } else {
            return view('Admin.Payments.payments-index', ['payments' => $paymentRequests, 'statistics' => $this->calculateStatistics()]);
        }

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $availableAmount = $seller->balance - 5; // Then Get this value from fees table
        $validation = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', "max:$availableAmount", 'min:10'],
        ], $this->attributes);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        } else {
            DB::beginTransaction();
            $paymentRequest = new PaymentRequest();
            $paymentRequest->amount = $request->amount;
            $paymentRequest->seller_id = $seller->id;
            $paymentRequest->save();

            $paymentRequest->statusHistories()->create([
                'statusable_type' => 'App\Models\PaymentRequest',
                'statusable_id' => $paymentRequest->id,
                'action' => 'Placed',
            ]);

            $seller->balance = DB::raw('balance -' . ($request->amount + 5));
            $seller->save();
            event(new PaymentRequestCreated($paymentRequest));
            DB::commit();
            // return redirect()->back()->with('success', 'Payment Request Placed Successfully');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentRequest = PaymentRequest::with(['seller.user', 'statusHistories'])->find($id);
        $this->authorize('view', $paymentRequest);

        return view('Seller.Payments.seller-payments-show', ['paymentRequest' => $paymentRequest]);
    }

    public function adminShow($id)
    {
        $paymentRequest = PaymentRequest::with(['seller.user', 'statusHistories'])->find($id);

        return view('Admin.Payments.payments-show', ['paymentRequest' => $paymentRequest]);
    }

    public function accept($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);

        $this->authorize('update', $paymentRequest);
        if ($paymentRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Cannot Accept a non-pending Request');
        }
        DB::beginTransaction();
        $paymentRequest->status = 'accepted';
        $paymentRequest->save();

        $paymentRequest->statusHistories()->create([
            'action' => 'Accepted',
            'statusable_type' => 'App\Models\PaymentRequest',
            'statusable_id' => $paymentRequest->id,
        ]);
        event(new PaymentRequestAccepted($paymentRequest));
        DB::commit();
        return redirect()->back()->with('success', 'Payment Request Accepted Successfully');
    }

    public function acceptAll()
    {

        $paymentRequests = PaymentRequest::where('status', 'pending')->with('statusHistories')->get();
        $this->authorize('acceptAll', PaymentRequest::class);
        if ($paymentRequests->count() == 0) {
            return redirect()->back()->with('error', "There Isn't Pending Requests To Accept");
        }
        DB::beginTransaction();
        foreach ($paymentRequests as $request) {
            $request->status = 'accepted';
            $request->save();

            $request->statusHistories()->create([
                'action' => 'Accepted',
                'statusable_type' => 'App\Models\PaymentRequest',
                'statusable_id' => $request->id,
            ]);
            event(new PaymentRequestAccepted($request));
        }

        DB::commit();
        return redirect()->back()->with('success', "{$paymentRequests->count()} Payment Requests Accepted Successfully");

    }
    public function reject($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);

        $this->authorize('update', $paymentRequest);
        if ($paymentRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Cannot Reject a non-pending Request');
        }
        DB::beginTransaction();
        $paymentRequest->status = 'rejected';
        $paymentRequest->save();

        $paymentRequest->seller->balance = DB::raw('balance + ' . $paymentRequest->amount + 5);
        $paymentRequest->seller->save();
        $paymentRequest->statusHistories()->create([
            'action' => 'Rejected',
            'statusable_type' => 'App\Models\PaymentRequest',
            'statusable_id' => $paymentRequest->id,
        ]);

        DB::commit();
        event(new PaymentRequestRejected($paymentRequest));
        return redirect()->back()->with('success', 'Payment Request Rejected Successfully');
    }
    public function rejectAll()
    {

        $paymentRequests = PaymentRequest::where('status', 'pending')->with('statusHistories')->get();
        $this->authorize('rejectAll', PaymentRequest::class);
        if ($paymentRequests->count() == 0) {
            return redirect()->back()->with('error', "There Isn't Pending Requests To Reject");
        }
        DB::beginTransaction();
        foreach ($paymentRequests as $request) {
            $request->status = 'rejected';
            $request->save();

            $request->seller->balance = DB::raw('balance + ' . ($request->amount + 5));
            $request->seller->save();

            $request->statusHistories()->create([
                'action' => 'Rejected',
                'statusable_type' => 'App\Models\PaymentRequest',
                'statusable_id' => $request->id,
            ]);
            event(new PaymentRequestRejected($request));
        }
        DB::commit();
        return redirect()->back()->with('success', "{$paymentRequests->count()} Payment Requests Rejected Successfully");

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentRequest $paymentRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentRequest $paymentRequest)
    {
        //
    }
    private function calculateStatistics()
    {

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $counts = [

            'total' => PaymentRequest::count(),
            'pending' => PaymentRequest::where('status', 'pending')->count(),
            'accepted' => PaymentRequest::where('status', 'accepted')->count(),
            'rejected' => PaymentRequest::where('status', 'rejected')->count(),
            'paid' => PaymentRequest::where('status', 'paid')->count(),
        ];
// Get the counts for each status in the current month
        $currentMonthCounts = [
            'total' => PaymentRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count(),
            'pending' => PaymentRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'pending')->count(),
            'accepted' => PaymentRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'accepted')->count(),
            'rejected' => PaymentRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'rejected')->count(),
            'paid' => PaymentRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'paid')->count(),
        ];

// Get the counts for each status in the previous month
        $previousMonthCounts = [
            'total' => PaymentRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count(),
            'pending' => PaymentRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'pending')->count(),
            'accepted' => PaymentRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'accepted')->count(),
            'rejected' => PaymentRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'rejected')->count(),
            'paid' => PaymentRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'paid')->count(),
        ];

// Calculate the difference for each status
        $difference = [
            'total' => $currentMonthCounts['total'] - $previousMonthCounts['total'],
            'pending' => $currentMonthCounts['pending'] - $previousMonthCounts['pending'],
            'accepted' => $currentMonthCounts['accepted'] - $previousMonthCounts['accepted'],
            'rejected' => $currentMonthCounts['rejected'] - $previousMonthCounts['rejected'],
            'paid' => $currentMonthCounts['paid'] - $previousMonthCounts['paid'],
        ];

        return compact('counts', 'difference', 'previousMonthCounts', 'currentMonthCounts');
    }
}
