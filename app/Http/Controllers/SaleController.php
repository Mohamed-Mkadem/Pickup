<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Revenue;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    protected $messages = [
        '*.id.exists' => 'Unknown Products',
        '*.product_id.exists' => 'Unknown Products',
    ];

    public function __construct()
    {
        $this->middleware('hasPublishedStore')->except(['adminIndex', 'adminFilter', 'adminShow', 'sales', 'sale', 'filterSales']);
    }

    public function sales($username)
    {
        $store = Store::where('username', $username)->first();

        if (!$store) {
            abort(404);
        }

        $sales = Sale::where('store_id', $store->id)->orderBy('created_at', 'desc')->paginate();
        return view('Admin.Stores.show_store_sales', ['sales' => $sales, 'store' => $store]);
    }
    public function sale($username, $id)
    {
        $store = Store::where('username', $username)->first();

        if (!$store) {
            abort(404);
        }
        $sale = Sale::with('store')->findOrFail($id);
        $saleProducts = ProductSale::where('sale_id', $sale->id)->paginate();
        return view('Admin.Stores.show_store_sale', ['sale' => $sale, 'saleProducts' => $saleProducts, 'store' => $store]);
    }
    public function filterSales(Request $request, $username)
    {
        $store = Store::where('username', $username)->firstOrFail();

        // if (!$store) {
        //     abort(404);
        // }
        $query = Sale::query();
        $query->where('store_id', $store->id);
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $sort = $request->sort ?? 'newest';

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

        if (!empty($minAmount)) {
            $query->where('amount', '>=', $minAmount);
        }
        if (!empty($maxAmount)) {
            $query->where('amount', '<=', $maxAmount);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort == 'highest_amount') {
            $query->orderBy('amount', 'desc');
        }
        if ($sort == 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        }
        $sales = $query->with('store')->paginate();
        return view('Admin.Stores.show_store_sales', ['sales' => $sales, 'store' => $store]);
    }
    public function adminIndex()
    {
        $sales = Sale::with('store')->orderBy('created_at', 'desc')->paginate();
        return view('Admin.Sales.admin-sales-index', ['sales' => $sales]);
    }
    public function adminShow($id)
    {
        $sale = Sale::with(['products', 'store'])->findOrFail($id);
        $saleProducts = ProductSale::where('sale_id', $sale->id)->paginate();

        return view('Admin.Sales.admin-sales-show', ['sale' => $sale, 'saleProducts' => $saleProducts]);
    }
    public function adminFilter(Request $request)
    {

        $query = Sale::query();

        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $sort = $request->sort ?? 'newest';

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

        if (!empty($minAmount)) {
            $query->where('amount', '>=', $minAmount);
        }
        if (!empty($maxAmount)) {
            $query->where('amount', '<=', $maxAmount);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort == 'highest_amount') {
            $query->orderBy('amount', 'desc');
        }
        if ($sort == 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        }
        $sales = $query->with('store')->paginate();
        return view('Admin.Sales.admin-sales-index', ['sales' => $sales]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $store = $seller->store;
        $sales = Sale::where('store_id', $store->id)->orderBy('created_at', 'desc')->paginate();

        return view('Seller.Sales.sales-index', ['sales' => $sales]);

    }
    public function filter(Request $request)
    {
        $store = Store::where('seller_id', Auth::user()->seller->id)->first();
        if (!$store) {
            return redirect()->back()->with('error', 'Oops! Something Went Wrong');
        }
        $query = Sale::query();
        $query->where('store_id', $store->id);

        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $sort = $request->sort ?? 'newest';

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

        if (!empty($minAmount)) {
            $query->where('amount', '>=', $minAmount);
        }
        if (!empty($maxAmount)) {
            $query->where('amount', '<=', $maxAmount);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort == 'highest_amount') {
            $query->orderBy('amount', 'desc');
        }
        if ($sort == 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        }
        $sales = $query->paginate();
        return view('Seller.Sales.sales-index', ['sales' => $sales]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $store = $seller->store;
        $categories = $store->categories()->where('status', 'active')->get();
        $query = Product::query();
        $query->where('store_id', $store->id);
        $query->where('status', 'active');
        $query->whereHas('category', function ($subQuery) {
            $subQuery->where('status', 'active');
        });
        $products = $query->with(['brand', 'category'])->get();

        return view('Seller.Sales.sales-create', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $store = $seller->store;
        $cartString = $request->input('cart');
        // dd($request->cart);
        $cart = json_decode($cartString, true);
        // dd($cart);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Invalid JSON, handle the error accordingly
            return redirect()->back()->with('error', 'Invalid cart data');
        }

        $validation = Validator::make($cart, [
            '*.id' => 'required|exists:products,id,store_id,' . $store->id,
            '*.name' => 'required|string',
            '*.price' => 'required|numeric',
            '*.brand' => 'required|string',
            '*.image' => 'required|url',
            '*.quantity' => ['required', 'integer', 'min:1',
                // ,new MaxQuantityRule('actual_id'),
            ],
        ], $this->messages);
        $validation->after(function ($validation) use ($cart) {
            foreach ($cart as $cart_item) {
                $product = Product::findOrFail($cart_item['id']);

                if ($product->quantity < $cart_item['quantity']) {
                    $validation->errors()->add(
                        '*.quantity', "The Maximum Quantity Of '{$cart_item['name']}' Is {$product->quantity}");

                }

            }
        });

        if ($validation->fails()) {
            // Validation failed
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();
            $sale = Sale::create([
                'store_id' => $store->id,
                'amount' => $this->getAmount($cart),
                'no_items' => $this->getNOItems($cart),
            ]);

            foreach ($cart as $product) {
                ProductSale::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'sub_total' => $product['price'] * $product['quantity'],
                ]);
                $dbProduct = Product::findOrFail($product['id']);
                $dbProduct->decrement('quantity', $product['quantity']);
            }
            $revenue = Revenue::create([
                'user_id' => $seller->user_id,
                'title' => "New Sale Added",
                'category' => 'Sale Placement',
                'description' => "<p>Sale #{$sale->id} Placed On " . Carbon::now() . "</p>",
                'amount' => $this->getAmount($cart),
                'revenueable_type' => get_class($sale),
                'revenueable_id' => $sale->id,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Sale Added Successfully');
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
        $seller = Seller::where('user_id', Auth::id())->first();
        $store = $seller->store;
        $sale = Sale::where('store_id', $store->id)->findorFail($id);
        $saleProducts = ProductSale::where('sale_id', $sale->id)->paginate();
        // dd($saleProducts);
        return view('Seller.Sales.sales-show', ['sale' => $sale, 'saleProducts' => $saleProducts]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::where('id', $id)->first();

        $this->authorize('delete', $sale);

        $saleProducts = ProductSale::where('sale_id', $sale->id)->get();
        if ($saleProducts) {

            try {
                DB::beginTransaction();
                foreach ($saleProducts as $saleProduct) {
                    $product = Product::find($saleProduct->product_id);
                    if ($product) {
                        $product->increment('quantity', $saleProduct->quantity);
                        $saleProduct->delete();
                    }
                    $saleProduct->delete();
                }
                $sale->revenues->first()->delete();
                $sale->delete();

                DB::commit();
                return redirect()->route('seller.sales.index')->with('success', 'Sale Deleted Successfully');
            } catch (\Throwable $th) {
                // throw $th;
                return redirect()->route('seller.sales.index')->with('error', 'Oops! Something Went Wrong');
                //throw $th;
            }
        } else {
            $sale->delete();
            return redirect()->route('seller.sales.index')->with('success', 'Sale Deleted Successfully');
        }
    }
    protected function getAmount($cart)
    {
        $amount = 0;
        foreach ($cart as $item) {
            $amount += $item['price'] * $item['quantity'];
        }
        return $amount;
    }
    protected function getNOItems($cart)
    {
        $no_items = 0;

        foreach ($cart as $item) {
            $no_items += $item['quantity'];
        }
        return $no_items;
    }
}
