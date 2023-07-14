<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\OrderProduct;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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
            $client->decrement('balance', $order->amount);
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

            // Order Place Event
            // Empty Cart using a listener or here
            DB::commit();
            return redirect()->back()->with('success', 'Order Placed Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function clientIndex()
    {
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $orders = Order::where('client_id', $client->id)->with('store')->paginate();
        return view('Client.Orders.client-orders-index', ['orders' => $orders]);
    }
    public function clientShow($id)
    {

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
