<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Fee;
use App\Models\Revenue;
use App\Models\Seller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    protected $messages = [
        'plan.between' => 'The Subscription Plan Must be between 1 Month and 12 Months',
    ];
    public function index()
    {
        $storeId = Auth::user()->seller->store->id;
        // dd($storeId);
        $subscriptions = Subscription::where('store_id', $storeId)->paginate();
        return view('Seller.Subscriptions.subscriptions-index', ['subscriptions' => $subscriptions]);

    }
    public function create()
    {
        $seller = Seller::where('user_id', Auth::id())->with('store')->first();
        $subscriptionFee = Fee::where('name', 'subscription')->first();
        // dd($subscriptionFee);
        return view('Seller.Subscriptions.subscriptions-create', ['seller' => $seller, 'fee' => $subscriptionFee]);
    }
    public function store(Request $request)
    {
        $admin = User::where('type', 'Admin')->first();
        $seller = Seller::where('user_id', Auth::id())->with('store')->first();
        $subscriptionFee = Fee::where('name', 'subscription')->first();

        $validation = Validator::make($request->all(), [
            'plan' => ['required', 'numeric', 'between :1,12'],
        ], $this->messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $store = $seller->store;

        $planPrice = $subscriptionFee->value * $request->plan;
        $planDuration = $request->plan == 1 ? '1 Month' : "$request->plan Months";

        if ($seller->balance < $planPrice) {
            return redirect()->back()->with('error', 'Your Balance is Insufficient To Purchase This Subscription');
        };

        if ($store->expiry_date < time()) {

            $newExpiryDate = strtotime("+$planDuration");
        } else {

            $newExpiryDate = strtotime($store->expiry_date . " +$planDuration");

        }
        try {
            //code...
            DB::beginTransaction();
            $newExpiryDate = date('Y-m-d', $newExpiryDate);
            $store->expiry_date = $newExpiryDate;
            $store->status = 'published';
            $store->save();
            $seller->balance = DB::raw('balance -' . $planPrice);
            $seller->save();
            $subscription = Subscription::create([
                'store_id' => $store->id,
                'amount' => $planPrice,
                'duration' => $planDuration,
            ]);

            $expense = Expense::create([
                'expensable_type' => get_class($subscription),
                'expensable_id' => $subscription->id,
                'user_id' => $seller->user_id,
                'amount' => $planPrice,
                'description' => "Subscription of {$planDuration} Bought On " . Carbon::now(),
                'title' => "Subscription of {$planDuration} Purchased",
                'category' => "Subscriptions Purchase",

            ]);
            $revenue = Revenue::create([
                'revenueable_type' => get_class($subscription),
                'revenueable_id' => $subscription->id,
                'user_id' => $admin->id,
                'amount' => $planPrice,
                'description' => "Subscription of {$planDuration} Sold On " . Carbon::now(),
                'title' => "Subscription of {$planDuration} Sold",
                'category' => "Subscriptions Sale",

            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Subscription Added Successfully, Your Store Will Be Published Until ' . $newExpiryDate);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something Went Wrong');
            //throw $th;
        }
    }

    public function adminIndex()
    {
        $subscriptions = Subscription::with('store')->paginate();
        return view('Admin.subscriptions', ['subscriptions' => $subscriptions]);
    }

    public function filter(Request $request)
    {
        $query = Subscription::query();
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $duration = $request->duration ?? 'all';
        // dd($duration);
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if (!empty($search)) {
            $query->where('id', 'like', "%$search%");
        }

        if ($duration != 'all') {
            $query->where('duration', 'like', "%$duration%");
        }

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'highest_duration') {
            $query->orderByRaw("CAST(SUBSTRING_INDEX(duration, ' ', 1) AS UNSIGNED) DESC");
        } elseif ($sort === 'lowest_duration') {
            $query->orderByRaw("CAST(SUBSTRING_INDEX(duration, ' ', 1) AS UNSIGNED) ASC");
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $subscriptions = $query->with('store')->paginate();
        return view('Admin.subscriptions', ['subscriptions' => $subscriptions]);
    }

}
