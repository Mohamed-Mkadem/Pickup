<?php

namespace App\Http\Controllers;

use App\Events\ClientCancelledOrder;
use App\Events\OrderAccepted;
use App\Events\OrderPlaced;
use App\Events\OrderReady;
use App\Events\OrderRejected;
use App\Events\SellerCancelledOrder;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\OrderProduct;
use App\Models\Revenue;
use App\Models\Seller;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $attributes = [
        'order_id' => 'Order ID',
    ];
    public function __construct()
    {
        $this->middleware('hasStore')->only(['index', 'show']);
    }
    // Track Order
    public function getOrder(Request $request)
    {
        $order_id = $request->order_id;
        if (!$order_id) {
            return redirect()->back()->with('error', 'The Order ID Is Required');
        }
        $order = Order::with(['store', 'client'])->find($order_id);
        $products = null;
        if ($order) {
            $products = OrderProduct::where('order_id', $order_id)->paginate();
        }
        return view('Front_End.trackOrder', ['order' => $order, 'products' => $products]);
    }

    // Admin Logic

    public function adminIndex()
    {
        $orders = Order::with(['store', 'client', 'client.user'])->orderBy('created_at', 'desc')->paginate();
        $this->authorize('viewAny', Order::class);
        return view('Admin.Orders.orders-index', ['orders' => $orders]);
    }
    public function adminShow($id)
    {
        $order = Order::with(['client', 'store', 'client.user', 'notes'])->findOrFail($id);
        $this->authorize('viewAny', Order::class);

        $products = OrderProduct::where('order_id', $order->id)->paginate();
        return view('Admin.Orders.orders-show', ['order' => $order, 'products' => $products]);
    }
    // Seller Logic
    public function index()
    {
        $seller = Seller::where('user_id', Auth::id())->firstOrFail();
        $store = $seller->store;
        $orders = Order::where('store_id', $store->id)->with('client')->orderBy('created_at', 'desc')->paginate();

        return view('Seller.Orders.seller-orders-index', ['orders' => $orders]);
    }

    public function filter(Request $request)
    {
        $user = Auth::user();

        $query = Order::query();
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $statuses = $request->status ?? [];

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

        if (!empty($search)) {
            $query->where('id', 'like', "%$search%");
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'highest_amount') {
            $query->orderBy('amount', 'desc');
        } elseif ($sort === 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($user->type == 'Admin') {
            $orders = $query->with(['store', 'client', 'client.user'])->paginate();
            return view('Admin.Orders.orders-index', ['orders' => $orders]);
        }
        if ($user->type == 'Seller') {
            $store = $user->seller->store;
            if (!$store) {
                abort(404);
            }
            $query->where('store_id', $store->id);
            $orders = $query->with('client')->paginate();
            return view('Seller.Orders.seller-orders-index', ['orders' => $orders]);
        }
        if ($user->type == 'Client') {
            $client = $user->client;
            $query->where('client_id', $client->id);
            $orders = $query->with('store')->paginate();
            return view('Client.Orders.client-orders-index', ['orders' => $orders]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function sellerCancel($id)
    {
        $order = Order::with('products')->findOrFail($id);
        // dd($order);
        $client = $order->client;
        // dd($client);
        $store = $order->store;
        $seller = $store->owner;
        $this->authorize('update', $order);
        $refund = [
            'percentage' => '0%',
            'value' => 0,
        ];
        $status = $order->status;
        $amount = $order->amount;
        if ($status == 'cancelled') {
            return redirect()->back()->with('error', 'This Order Is already Cancelled');
        }
        if ($status == 'accepted') {
            $refund['percentage'] = '10%';
            $refund['value'] = ($amount / 100) * 10;
        }
        if ($status == 'ready') {
            $refund['percentage'] = '20%';
            $refund['value'] = ($amount / 100) * 20;
        }

        if (($store->balance + $seller->balance) < $refund['value']) {
            return redirect()->back()->with('error', "Your Balance is Insufficient to cover this order cancellation fee ({$refund['value']} TND), Please Top-up your account or complete the order process, or try to find a solution with the customer");
        }
        // dd($refund);
        $charges = [
            'store' => 0,
            'seller' => 0,
        ];
        if ($store->balance >= $refund['value']) {
            $charges['store'] = $refund['value'];
        } else {
            $charges['store'] = $store->balance;
        }

        if ($charges['store'] < $refund['value']) {
            $charges['seller'] = $refund['value'] - $charges['store'];
        }

        // dd($charges);
        try {
            DB::beginTransaction();
            // Change Order's status
            $order->status = 'cancelled';
            $order->save();

            // Return Money to the client
            $client->balance = DB::raw('balance +' . ($amount + $refund['value']));
            $client->save();

            // Update products Quantity
            foreach ($order->products as $product) {
                $product->increment('quantity', $product->order_products->quantity);

            }

            // Deduct the charges from the store balance
            $store->balance = DB::raw('balance -' . $charges['store']);
            $store->save();
            // Deduct the charges from the seller balance
            $seller->balance = DB::raw('balance -' . $charges['seller']);
            $seller->save();

            $expense = Expense::create([
                'expensable_type' => get_class($order),
                'expensable_id' => $order->id,
                'user_id' => $seller->user_id,
                'amount' => $refund['value'],
                'description' => "Order {$order->id} Cancelled on " . Carbon::today(),
                'title' => "Order {$order->id} Cancelled",
                'category' => "Order Cancellation",

            ]);
            // Add The Event
            event(new SellerCancelledOrder($order, $status, $refund));

            // Add Status History
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Cancelled',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Order Cancelled Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }
    }

    public function accept(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $this->authorize('update', $order);

        $status = $order->status;

        if ($status == 'accepted') {
            return redirect()->back()->with('error', 'This Order Is already Accepted');
        }
        if ($status != 'pending') {
            return redirect()->back()->with('error', 'Only Pending Orders Can Be Accepted');
        }

        try {
            DB::beginTransaction();
            $order->status = 'accepted';
            $order->save();

            // Add Status History
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Accepted',
            ]);

            // Add Event
            event(new OrderAccepted($order));

            // Add Notes if there is
            if ($request->note) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'note' => $request->note,
                    'notable_id' => $order->store->id,
                    'notable_type' => "App\Models\Store",
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Order Accepted Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }
    }
    public function ready($id)
    {

        $order = Order::findOrFail($id);
        $this->authorize('update', $order);

        $status = $order->status;

        if ($status == 'ready') {
            return redirect()->back()->with('error', 'This Order Is already Ready');
        }

        if ($status != 'accepted') {
            return redirect()->back()->with('error', 'Only Accepted Orders Can Be Marked As Ready');
        }

        try {
            DB::beginTransaction();
            $order->status = 'ready';
            $order->save();

            // Add Status History
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Ready',
            ]);

            // Add Event
            event(new OrderReady($order));

            DB::commit();
            return redirect()->back()->with('success', 'The Order Is Ready');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }
    }
    public function reject(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $this->authorize('update', $order);
        $refund = [
            'percentage' => 0,
            'value' => 0,
        ];
        $client = $order->client;
        $status = $order->status;
        $amount = $order->amount;

        if ($status == 'rejected') {
            return redirect()->back()->with('error', 'This Order Is already Rejected');
        }
        if ($status != 'pending') {
            return redirect()->back()->with('error', 'Only Pending Orders Can Be Rejected');
        }
        try {
            DB::beginTransaction();
            $order->status = 'rejected';
            $order->save();

            $client->balance = DB::raw('balance + ' . $amount);
            $client->save();

            // Update products Quantity
            foreach ($order->products as $product) {
                $product->increment('quantity', $product->order_products->quantity);

            }

            // Add Status History
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Rejected',
            ]);

            // Add Event
            event(new OrderRejected($order));

            // Add Notes if there is
            if ($request->note) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'note' => $request->note,
                    'notable_id' => $order->store->id,
                    'notable_type' => "App\Models\Store",
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Order Rejected Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went Wrong');
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['client', 'client.user', 'pickRequests', 'review', 'review.client'])->findOrFail($id);
        $this->authorize('view', $order);

        $orderProducts = OrderProduct::where('order_id', $order->id)->paginate();

        return view('Seller.Orders.seller-orders-show', ['order' => $order, 'products' => $orderProducts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    // Client Logic
    public function placeOrder(Request $request, $storeID)
    {
        $store = Store::findOrFail($storeID);
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $cart = $client->carts()->where('store_id', $storeID)->first();
        // dd($cart->products()->withTrashed()->get());
        $cartProducts = $cart->products()->withTrashed()->get();
        // dd($cart->products()->count());
        if (!$cart || !$cartProducts) {
            return redirect()->back()->with('error', 'You Need To Add At Least One Product To Your Cart To Place An Order');
        }
        if ($client->balance < $cart->amount) {
            return redirect()->back()->with('error', 'Your Balance Is Insufficient To Place This Order');
        }

        $validation = Validator::make($request->all(), [
            'note' => ['nullable', 'string', 'max:500'],
        ]);
        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->deleted_at || $cartProduct->status == 'inactive') {
                $validation->after(function ($validation) use ($cartProduct) {
                    $validation->errors()->add(
                        'name', "The Product  '{$cartProduct->cart_products->name}' Has Been Deleted Or Hidden By The Store, You need to remove it from your cart, Or Contact the store owner to inquire about the availability or status of the product"
                    );
                });

            }
            if ($cartProduct->cart_products->quantity > $cartProduct->quantity) {
                $validation->after(function ($validation) use ($cartProduct) {
                    $validation->errors()->add(
                        'quantity', "The Quantity Of {$cartProduct->cart_products->name} Has Been Changed, It's Now {$cartProduct->quantity}, Please Update Your Cart"
                    );
                });
            }

        }
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        try {
            DB::beginTransaction();
            // Create Order
            $order = Order::create([
                'client_id' => $client->id,
                'store_id' => $storeID,
                'no_items' => $cart->products()->count(),
                'amount' => $cart->amount,
            ]);
            // Add Order Products and decrement the quantity of the product
            foreach ($cartProducts as $cartProduct) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $cartProduct->cart_products->product_id,
                    'price' => $cartProduct->cart_products->price,
                    'name' => $cartProduct->cart_products->name,
                    'image' => $cartProduct->cart_products->image,
                    'quantity' => $cartProduct->cart_products->quantity,
                    'sub_total' => $cartProduct->cart_products->sub_total,
                ]);
                $cartProduct->decrement('quantity', $cartProduct->cart_products->quantity);
            }
            // Decrement the order amount from the client's balance
            $client->balance = DB::raw('balance -' . $order->amount);
            $client->save();
            // Add Placed Status
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Placed',
            ]);

            // Add A Note If There Is
            if ($request->note) {
                OrderNote::create([

                    'order_id' => $order->id,
                    'note' => $request->note,
                    'notable_id' => $client->id,
                    'notable_type' => "App\Models\Client",
                ]);
            }

            DB::commit();
            // Order Place Event
            event(new OrderPlaced($order));
            // Empty Cart using a listener or here
            foreach ($cartProducts as $cartProduct) {
                $cartProduct->cart_products->delete();
            }
            $cart->amount = 0;
            $cart->save();
            return redirect()->back()->with('success', 'Order Placed Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something Went Wrong');
            throw $th;
        }
    }
    public function clientIndex()
    {
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $orders = Order::where('client_id', $client->id)->with('store')->orderBy('created_at', 'desc')->paginate();
        return view('Client.Orders.client-orders-index', ['orders' => $orders]);
    }
    public function clientShow($id)
    {
        $order = Order::with(['store', 'notes', 'statusHistories', 'store.sector', 'pickRequests', 'review'])->findOrFail($id);

        $this->authorize('show', $order);
        $orderProducts = OrderProduct::where('order_id', $order->id)->paginate();

        return view('Client.Orders.client-orders-show', ['order' => $order, 'products' => $orderProducts]);
    }
    public function cancel($id)
    {
        $order = Order::with('products')->findOrFail($id);
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $this->authorize('cancel', $order);

        $refund = [
            'percentage' => '0%',
            'value' => 0,
        ];
        $status = $order->status;
        $amount = $order->amount;
        if ($status == 'cancelled') {
            return redirect()->back()->with('error', 'This Order Is already Cancelled');
        }
        if ($status == 'accepted') {
            $refund['percentage'] = '10%';
            $refund['value'] = ($amount / 100) * 10;
        }
        if ($status == 'ready') {
            $refund['percentage'] = '20%';
            $refund['value'] = ($amount / 100) * 20;
        }

        try {
            DB::beginTransaction();
            // Change Order's status
            $order->status = 'cancelled';
            $order->save();

            // Return Money to the client
            $client->balance = DB::raw('balance +' . ($amount - $refund['value']));
            $client->save();

            // Update products Quantity
            foreach ($order->products as $product) {
                $product->increment('quantity', $product->order_products->quantity);

            }
            if ($refund['value'] > 0) {
                // Add the refund amount to the store balance
                $order->store->balance = DB::raw('balance + ' . $refund['value']);
                $order->store->save();
                $revenue = Revenue::create([
                    'user_id' => $order->store->owner->user_id,
                    'title' => "New Order Cancelled",
                    'category' => 'Client Order Cancellation',
                    'description' => "<p>Order #{$order->id} Cancelled On " . Carbon::now() . "</p>",
                    'amount' => $refund['value'],
                    'revenueable_type' => get_class($order),
                    'revenueable_id' => $order->id,
                ]);
            }
            // Add The Event
            event(new ClientCancelledOrder($order, $status, $refund));

            // Add Status History
            $order->statusHistories()->create([
                'statusable_type' => 'App\Models\Order',
                'statusable_id' => $order->id,
                'action' => 'Cancelled',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Order Cancelled Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went Wrong');
            throw $th;
        }

    }
}
/*
- Check Client Balance = Done
- Validate Note = Done
- DB Transaction Begin
- Check products quantities and statuses = Done
- Create the order from the cart = Done
- Remove the amount from the client's balance = Done
- Create the order placed status = Done
- If There Is Note Create It = Done
- Create the order placed Event
- Empty The Cart
- Return Back with success = Done
- DB Transaction End
 */
