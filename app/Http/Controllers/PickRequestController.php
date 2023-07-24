<?php

namespace App\Http\Controllers;

use App\Events\PickRequestConfirmed;
use App\Events\PickRequestCreated;
use App\Events\PickRequestRejected;
use App\Models\Order;
use App\Models\PickRequest;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickRequestController extends Controller
{

    public function store(Request $request)
    {
        $orderID = $request->order_id;
        if (!$orderID) {
            abort(404);
        }
        $order = Order::where('store_id', Auth::user()->seller->store->id)->findOrFail($orderID);

        $status = $order->status;
        if ($order->hasPendingPickRequest()) {
            return redirect()->back()->with('error', 'This Order Has Already A Pending Pick Request');

        }
        if ($status != 'ready') {

            return redirect()->back()->with('error', 'Only Ready Orders Can Have Pick Requests');
        }

        try {
            $pickRequest = PickRequest::create([
                'order_id' => $orderID,
            ]);
            event(new PickRequestCreated($pickRequest));
            return redirect()->back()->with('success', 'Pick Request Sent Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function refuse($id)
    {
        $pickRequest = PickRequest::findOrFail($id);
        $this->authorize('update', $pickRequest);

        if ($pickRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Cannot Refuse A non pending Pick Requests');
        }
        try {
            $pickRequest->status = 'rejected';
            $pickRequest->save();
            event(new PickRequestRejected($pickRequest));

            return redirect()->back()->with('success', 'Pick Request Refused Successfully');
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
    public function confirm($id)
    {
        $pickRequest = PickRequest::findOrFail($id);
        $this->authorize('update', $pickRequest);

        if ($pickRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Cannot Confirm A non pending Pick Requests');
        }
        $order = $pickRequest->order;

        $store = $order->store;
        try {
            DB::beginTransaction();
            // Change Request's Status
            $pickRequest->status = 'confirmed';
            $pickRequest->save();

            // Change order's status

            $order->status = 'picked';
            $order->save();

            // Add order's amount to store balance
            $store->balance = DB::raw('balance + ' . $order->amount);
            $store->save();

            $revenue = Revenue::create([
                'user_id' => $store->owner->user_id,
                'title' => "New Order Completed",
                'category' => 'Order Placement',
                'description' => "<p>Order #{$order->id} Placed On " . Carbon::now() . "</p>",
                'amount' => $order->amount,
                'revenueable_type' => get_class($order),
                'revenueable_id' => $order->id,
            ]);
            // Add Status History To The Order
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Picked',
            ]);

            // Event
            event(new PickRequestConfirmed($pickRequest));

            DB::commit();
            return redirect()->back()->with('success', "Pickup Confirmed Successfully, Don't Forget To Review The Order Process");
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
// Change Request Status
// Add event
// Change Order Status
// Add order's amount to store balance
// Add Status History to Order
//
//
//
//
//
//
//
