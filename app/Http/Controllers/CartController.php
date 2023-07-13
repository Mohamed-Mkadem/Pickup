<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Client;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
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
    public function newCart($storeID, $clientID)
    {
        $cart = Cart::create([
            'store_id' => $storeID,
            'client_id' => $clientID,
            'amount' => 0,
        ]);

        return $cart;
    }

    // public function addProduct(Request $request, $storeID)
    // {
    //     $store = Store::findOrFail($storeID);
    //     if (!$store->isPublished()) {
    //         return redirect()->back();
    //     }
    //     $client = Client::where('user_id', Auth::id())->first();
    //     if (!$client) {
    //         abort(422);
    //     }
    //     $validation = Validator::make($request->all(), [
    //         'id' => ['required', 'exists:products,id,store_id,' . $storeID],
    //         'name' => 'required|string',
    //         'price' => 'required|numeric|min:0.01',
    //         'image' => 'required|url',
    //         'quantity' => ['min:1', 'numeric'],
    //     ]);
    //     $quantity = (int) $request->quantity ? $request->quantity : 1;

    //     if (!$client->hasCart($store)) {
    //         $cart = $this->newCart($store->id, $client->id);

    //     }
    //     $cart = $client->carts()->where('store_id', $store->id)->first();
    //     $existingProduct = $cart->products()->where('product_id', $request->id)->first();
    //     if ($existingProduct) {
    //         $quantity += $existingProduct->quantity;
    //     }
    //     $validation->after(function ($validation) use ($request, $quantity, $existingProduct) {
    //         $product = Product::findOrFail($request->id);
    //         if ($quantity > $product->quantity) {
    //             $validation->errors()->add(
    //                 'quantity', "The Maximum Quantity of {$product->name} is {$product->quantity}, " . ($existingProduct ? "You Have Already Added This Product On your Cart {$existingProduct->cart_products->quantity} " . ($existingProduct->cart_products->quantity == 1 ? 'Time' : 'Times') : '')

    //             );
    //         }
    //     });

    //     if ($validation->fails()) {

    //         return redirect()->back()->withErrors($validation)->withInput();
    //     }

    //     if (!$existingProduct) {
    //         DB::beginTransaction();
    //         $newProduct = CartProduct::create([
    //             'cart_id' => $cart->id,
    //             'product_id' => $request->id,
    //             'price' => $request->price,
    //             'name' => $request->name,
    //             'image' => $request->image,
    //             'quantity' => $quantity,
    //             'sub_total' => $quantity * $request->price,
    //         ]);
    //         DB::commit();
    //         $amount = 0;
    //         foreach ($cart->products as $product) {
    //             $amount += $product->cart_products->sub_total;
    //         }

    //         $cart->amount = $amount;
    //         $cart->save();
    //         return redirect()->back()->with('success', 'Product Added To Cart Successfully');
    //     } else {
    //         DB::beginTransaction();
    //         $existingProduct->cart_products->increment('quantity', $quantity);
    //         $existingProduct->cart_products->sub_total = $existingProduct->cart_products->quantity * $existingProduct->cart_products->price;
    //         $existingProduct->cart_products->save();

    //         DB::commit();
    //         $amount = 0;
    //         foreach ($cart->products as $product) {
    //             $amount += $product->cart_products->sub_total;
    //         }

    //         $cart->amount = $amount;
    //         $cart->save();
    //         return redirect()->back()->with('success', 'Product Added To Cart Successfully');
    //     }

    // }
    public function addProduct(Request $request, $storeID)
    {
        $store = Store::findOrFail($storeID);
        if (!$store->isPublished()) {
            return redirect()->back();
        }

        $client = Client::where('user_id', Auth::id())->firstOrFail();

        $validation = Validator::make($request->all(), [
            'id' => ['required', 'exists:products,id,store_id,' . $storeID],
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'image' => 'required|url',
            'quantity' => ['nullable', 'min:1', 'numeric'],
        ]);

        $quantity = $request->filled('quantity') ? (int) $request->quantity : 1;

        $cart = $client->carts()->where('store_id', $store->id)->first();
        if (!$cart) {
            $cart = $client->carts()->create(['store_id' => $store->id, 'amount' => 0]);
        }

        $existingProduct = $cart->products()->where('product_id', $request->id)->first();
        if ($existingProduct) {
            $quantity += $existingProduct->quantity;
        }

        $validation->after(function ($validation) use ($request, $quantity, $existingProduct) {
            $product = Product::findOrFail($request->id);
            if ($quantity > $product->quantity) {
                $message = "The Maximum Quantity of {$product->name} is {$product->quantity}";
                if ($existingProduct) {
                    $message .= ". You have already added this product to your cart {$existingProduct->cart_products->quantity} time(s)";
                }
                $validation->errors()->add('quantity', $message);
            }
        });

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        DB::beginTransaction();

        if (!$existingProduct) {
            CartProduct::create([
                'cart_id' => $cart->id,
                'product_id' => $request->id,
                'price' => $request->price,
                'name' => $request->name,
                'image' => $request->image,
                'quantity' => $quantity,
                'sub_total' => $quantity * $request->price,
            ]);
        } else {
            $existingProduct->cart_products->increment('quantity', $quantity);
            $existingProduct->cart_products->sub_total = $existingProduct->cart_products->quantity * $existingProduct->cart_products->price;
            $existingProduct->cart_products->save();
        }

        $amount = $cart->products->sum(function ($product) {
            return $product->cart_products->sub_total;
        });

        $cart->amount = $amount;
        $cart->save();

        DB::commit();

        return redirect()->back()->with('success', 'Product Added To Cart Successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $oldCart = Cart::findOrFail($id);
        $this->authorize('update', $oldCart);
        $newCart = $request->cart;
        if (!$newCart) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
        $newCart = json_decode($newCart, true);

        $store = $oldCart->store;
        $validation = Validator::make($newCart, [
            '*.product_id' => ['required', 'exists:products,id,store_id,' . $store->id],
            '*.name' => 'required|string',
            '*.price' => 'required|numeric|min:0.01',
            '*.image' => 'required|url',
            '*.quantity' => ['required', 'min:1'],
        ]);
        $validation->after(function ($validation) use ($newCart) {
            foreach ($newCart as $newCart_item) {
                $product = Product::where('status', 'active')->find($newCart_item['product_id']);
                if (!$product) {
                    $validation->errors()->add(
                        '*.name', "Product '{$newCart_item['name']}' Is Deleted Or Hidden"
                    );

                }
                if ($product->quantity < $newCart_item['quantity']) {
                    $validation->errors()->add(
                        '*.quantity', "The Maximum Quantity Of '{$newCart_item['name']}' Is {$product->quantity}");

                }

            }
        });
        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();
            foreach ($oldCart->products as $product) {
                $product->cart_products->delete();

            }
            $oldCart->amount = 0;
            $oldCart->save();
            foreach ($newCart as $newProduct) {
                $newAddedProduct = CartProduct::create([
                    'cart_id' => $oldCart->id,
                    'product_id' => $newProduct['product_id'],
                    'price' => $newProduct['price'],
                    'name' => $newProduct['name'],
                    'image' => $newProduct['image'],
                    'quantity' => $newProduct['quantity'],
                    'sub_total' => $newProduct['quantity'] * $newProduct['price'],
                ]);
                $oldCart->increment('amount', $newAddedProduct->sub_total);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Cart Updated Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function empty($id) {
        $cart = Cart::findOrFail($id);
        $this->authorize('update', $cart);
        try {
            DB::beginTransaction();
            foreach ($cart->products as $cartProduct) {
                $cartProduct->cart_products->delete();
            }
            $cart->amount = 0;
            $cart->save();
            DB::commit();
            return redirect()->back()->with('success', 'Cart Emptied Successfully');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
