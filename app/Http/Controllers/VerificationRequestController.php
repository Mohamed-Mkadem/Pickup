<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\support\facades\Validator;

class VerificationRequestController extends Controller
{
    public $attributes = [
        'nid_front' => 'NID Front Photo',
        'nid_back' => 'NID Back Photo',
        'commercial_register' => 'Commercial Register',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verificationRequests = VerificationRequest::where('seller_id', Auth::user()->seller->id)->paginate();

        return view('Seller.Verification.verification-index', ['verificationRequests' => $verificationRequests]);
    }
    private function calculateStatistics()
    {

        // $currentMonthStart = Carbon::now()->startOfMonth();
        // $currentMonthEnd = Carbon::now()->endOfMonth();
        // $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        // $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        // $currentMonthTotalRequests = VerificationRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        // $previousMonthTotalRequests = VerificationRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        // $totalChange = $currentMonthTotalRequests - $previousMonthTotalRequests;

        // return compact('totalRequests', 'pendingRequests', 'approvedRequests', 'rejectedRequests', 'totalChange');
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
// Get the counts for each status in all time
        $counts = [

            'total' => VerificationRequest::count(),
            'pending' => VerificationRequest::where('status', 'pending')->count(),
            'approved' => VerificationRequest::where('status', 'approved')->count(),
            'rejected' => VerificationRequest::where('status', 'rejected')->count(),
        ];
// Get the counts for each status in the current month
        $currentMonthCounts = [
            'total' => VerificationRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count(),
            'pending' => VerificationRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'pending')->count(),
            'approved' => VerificationRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'approved')->count(),
            'rejected' => VerificationRequest::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', 'rejected')->count(),
        ];

// Get the counts for each status in the previous month
        $previousMonthCounts = [
            'total' => VerificationRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count(),
            'pending' => VerificationRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'pending')->count(),
            'approved' => VerificationRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'approved')->count(),
            'rejected' => VerificationRequest::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', 'rejected')->count(),
        ];

// Calculate the difference for each status
        $difference = [
            'total' => $currentMonthCounts['total'] - $previousMonthCounts['total'],
            'pending' => $currentMonthCounts['pending'] - $previousMonthCounts['pending'],
            'approved' => $currentMonthCounts['approved'] - $previousMonthCounts['approved'],
            'rejected' => $currentMonthCounts['rejected'] - $previousMonthCounts['rejected'],
        ];

        return compact('counts', 'difference', 'previousMonthCounts', 'currentMonthCounts');
    }
    public function filter(Request $request)
    {
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? ['pending', 'approved', 'rejected'];
        $sort = $request->sort ?? 'newest';
        $query = VerificationRequest::query();
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $query->where('created_at', '<=', $maxDate);
        }

        if (!empty($search)) {
            $query->where('id', '=', $search);
        }

        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        // Apply the order by clause
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        // dd($query);
        $verificationRequests = $query->paginate();
        $statistics = $this->calculateStatistics();
        return view('Admin.Verification.admin-verification-index', [
            'verificationRequests' => $verificationRequests,
            'statistics' => $statistics,
        ]);
    }
    public function adminIndex()
    {
        $verificationRequests = VerificationRequest::with('seller.user')->paginate();
        $statistics = $this->calculateStatistics();
        return view('Admin.Verification.admin-verification-index', [
            'verificationRequests' => $verificationRequests,
            'statistics' => $statistics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Seller.Verification.verification-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add a condition on blade template to check that the seller hasn't any pending request or it is verified
        $seller = Auth::user()->seller;

        $validated = Validator::make($request->all(), [
            'photo' => ['required', 'file', 'image', 'mimes:jpeg,jpg', 'max:1024000'],
            'nid_front' => ['required', 'file', 'image', 'mimes:jpeg,jpg', 'max:1024000'],
            'nid_back' => ['required', 'file', 'image', 'mimes:jpeg,jpg', 'max:1024000'],
            'commercial_register' => ['required', 'file', 'image', 'mimes:jpeg,jpg', 'max:1024000'],
        ], [], $this->attributes);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            $photo = $request->file('photo');
            $nid_front = $request->file('nid_front');
            $nid_back = $request->file('nid_back');
            $commercial_register = $request->file('commercial_register');
            $photoPath = $photo->store('/v_reqs/photos', [
                'disk' => 'public',
            ]);
            $nid_frontPath = $nid_front->store('/v_reqs/nidFront', [
                'disk' => 'public',
            ]);
            $nid_backPath = $nid_back->store('/v_reqs/nidBack', [
                'disk' => 'public',
            ]);
            $com_rPath = $commercial_register->store('/v_reqs/comR', [
                'disk' => 'public',
            ]);
            DB::beginTransaction();
            $verificationRequest = VerificationRequest::create([
                'seller_id' => $seller->id,
                'photo' => $photoPath,
                'nid_front' => $nid_frontPath,
                'nid_back' => $nid_backPath,
                'commercial_register' => $com_rPath,
            ]);
            $verificationRequest->statusHistories()->create([
                'statusable_type' => 'App\Models\VerificationRequest',
                'statusable_id' => $verificationRequest->id,
                'action' => 'Placed',
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Verification Request Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $verificationRequest = VerificationRequest::with('seller.user', 'statusHistories')->find($id);

        if (!$verificationRequest) {
            return back()->with('error', 'Could Not Find The specified Verification Request');
        }
        $this->authorize('view', $verificationRequest);
        return view('Seller.Verification.verification-show', ['request' => $verificationRequest]);

    }
    public function adminShow($id)
    {
        $verificationRequest = VerificationRequest::with('seller.user', 'statusHistories')->find($id);
        if (!$verificationRequest) {
            return back()->with('error', 'Could Not Find The specified Verification Request');
        }

        return view('Admin.Verification.admin-verification-show', ['request' => $verificationRequest]);

    }

    public function edit(VerificationRequest $verificationRequest)
    {
        //
    }

    public function approve($id)
    {
        $verificationRequest = VerificationRequest::with('seller.user', 'statusHistories')->find($id);
        if (!$verificationRequest) {
            return back()->with('error', 'Could Not Find The specified Verification Request');
        }
        if ($verificationRequest->status != 'pending') {
            return back()->with('error', 'Could Not Approve a Non-Pendig Verification Request');
        }
        DB::beginTransaction();
        $verificationRequest->update([
            'status' => 'approved',
        ]);
        $verificationRequest->seller->update([
            'verification' => 'Verified',
        ]);
        $verificationRequest->statusHistories()->create([
            'action' => 'Approved',
            'statusable_type' => 'App\Models\VerificationRequest',
            'statusable_id' => $verificationRequest->id,

        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Verification Request Approved Successfully');

    }
    public function reject($id)
    {
        $verificationRequest = VerificationRequest::with('seller.user', 'statusHistories')->find($id);
        if (!$verificationRequest) {
            return back()->with('error', 'Could Not Find The specified Verification Request');
        }

        if ($verificationRequest->status != 'pending') {
            return back()->with('error', 'Could Not Reject a Non-Pendig Verification Request');
        }

        DB::beginTransaction();
        $verificationRequest->update([
            'status' => 'rejected',
        ]);

        $verificationRequest->statusHistories()->create([
            'action' => 'Rejected',
            'statusable_type' => 'App\Models\VerificationRequest',
            'statusable_id' => $verificationRequest->id,

        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Verification Request Rejected Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VerificationRequest $verificationRequest)
    {
        //
    }
}
