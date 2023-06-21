<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Seller;
use App\Models\Subscription;
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
        $seller = Seller::where('user_id', Auth::id())->with('store')->first();
        $subscriptionFee = Fee::where('name', 'subscription')->first();
        // dd($request->plan);
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
        DB::beginTransaction();
        $newExpiryDate = date('Y-m-d', $newExpiryDate);
        $store->expiry_date = $newExpiryDate;
        $store->status = 'published';
        $store->save();
        $seller->balance = DB::raw('balance -' . $planPrice);
        $seller->save();
        Subscription::create([
            'store_id' => $store->id,
            'amount' => $planPrice,
            'duration' => $planDuration,
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Subscription Added Successfully, Your Store Will Be Published Until ' . $newExpiryDate);
    }
}
