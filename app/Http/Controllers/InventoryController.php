<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public $brands;

    public function __construct()
    {

        $this->middleware('hasStore')->only(['create', 'edit', 'show', 'store', 'filter']);
        $this->brands = Brand::where('status', 'active')->get();

    }
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->seller->store->id)->with(['store', 'category', 'brand'])->orderBy('created_at', 'desc')->paginate();
        $store = Auth::user()->seller->store;

        $categories = Category::where('store_id', $store->id)->get();

        $inventoryFinancials = $this->inventoryFinancials($products);
        $inventoryStatuses = $this->inventoryStatuses($products);
        return view('Seller.inventory', [
            'inventoryStatuses' => $inventoryStatuses,
            'inventoryFinancials' => $inventoryFinancials,
            'products' => $products,
            'brands' => $this->brands,
            'categories' => $categories]);
    }
    private function inventoryFinancials($products)
    {

        $stock_cost = 0;
        $stock_price = 0;
        $expected_earnings = 0;

        foreach ($products as $product) {
            $stock_cost += ($product->cost_price * $product->quantity);
            $stock_price += ($product->price * $product->quantity);
        }
        $expected_earnings = $stock_price - $stock_cost;

        return compact('stock_cost', 'stock_price', 'expected_earnings');
    }
    private function inventoryStatuses($products)
    {
        $store = Auth::user()->seller->store;
        // Search for count problem I get it 23 although I have 26 products on the db
        // The problem is that I have 3 products soft deleted
        $all = Product::where('store_id', $store->id)->where('store_id', $store->id)->count();
        $inStock = Product::whereColumn('quantity', '>', 'stock_alert')->where('store_id', $store->id)->count();
        $outOfStock = Product::where('quantity', 0)->where('store_id', $store->id)->count();
        $stockAlert = Product::whereColumn('quantity', '<=', 'stock_alert')->where('quantity', '>', 0)->where('store_id', $store->id)->count();

        return compact('all', 'inStock', 'outOfStock', 'stockAlert');
    }

    public function manage(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('manage', $product);

        $validation = Validator::make($request->all(), [
            'operation' => ['required', 'in:add,deduct'],
            'quantity' => ['required', 'min:1', 'numeric'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }
        if ($request->operation == 'add') {

            $product->quantity = DB::raw('quantity + ' . $request->quantity);
            $product->save();
        } elseif ($request->operation == 'deduct') {
            if (($product->quantity - $request->quantity) < 0) {
                return redirect()->back()->with('error', 'The Minimum Quantity Of A Product Is 0');
            }
            $product->quantity = DB::raw('quantity - ' . $request->quantity);
            $product->save();

        }
        return redirect()->back()->with('success', 'Product Quantity Updated Successfully');

    }
    public function filter(Request $request)
    {
        $query = Product::query();
        $store = Auth::user()->seller->store;
        $storeCategories = Category::where('store_id', $store->id)->get();
        $query->where('store_id', $store->id);
        $search = $request->search ?? '';
        $minQuantity = $request->min_quantity ?? '';
        $maxQuantity = $request->max_quantity ?? '';
        $minPrice = $request->min_price ?? '';
        $maxPrice = $request->max_price ?? '';
        $minSalePrice = $request->min_sale_price ?? '';
        $maxSalePrice = $request->max_sale_price ?? '';
        $categories = $request->categories ?? [];
        $brands = $request->brands ?? [];
        // $statuses = $request->statuses ?? [];
        $units = $request->units ?? [];
        $sort = $request->sort ?? '';
        $stock_statuses = $request->stock_statuses ?? [];
        $query->where('store_id', $store->id);
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if (!empty($maxSalePrice)) {
            $query->where('cost_price', '<=', $maxSalePrice);
        }
        if (!empty($minSalePrice)) {
            $query->where('cost_price', '>=', $minSalePrice);
        }
        if (!empty($maxQuantity)) {
            $query->where('quantity', '<=', $maxQuantity);
        }
        if (!empty($minQuantity)) {
            $query->where('quantity', '>=', $minQuantity);
        }
        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        if (!empty($units)) {
            $query->whereIn('unit', $units);
        }

        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');

        } elseif ($sort == 'highest_sale_price') {
            $query->orderBy('price', 'desc');
        } elseif ($sort == 'lowest_sale_price') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'highest_cost_price') {
            $query->orderBy('cost_price', 'desc');
        } elseif ($sort == 'lowest_cost_price') {
            $query->orderBy('cost_price', 'asc');
        } elseif ($sort == 'highest_quantity') {
            $query->orderBy('quantity', 'desc');
        } elseif ($sort == 'lowest_quantity') {
            $query->orderBy('quantity', 'asc');
        }

        $query->where(function ($subquery) use ($stock_statuses) {
            if (in_array('in stock', $stock_statuses)) {
                $subquery->where('quantity', '>', 0)
                    ->whereColumn('quantity', '>', 'stock_alert');
            }

            if (in_array('out of stock', $stock_statuses)) {
                $subquery->orWhere('quantity', 0);
            }

            if (in_array('stock alert', $stock_statuses)) {
                $subquery->orWhereColumn('stock_alert', '>=', 'quantity')->where('quantity', '>', 0);
            }
        });

        $products = $query->with(['store', 'category'])->paginate();

        $inventoryFinancials = $this->inventoryFinancials($products);
        $inventoryStatuses = $this->inventoryStatuses($products);
        return view('Seller.inventory', [
            'inventoryStatuses' => $inventoryStatuses,
            'inventoryFinancials' => $inventoryFinancials,
            'products' => $products,
            'brands' => $this->brands,
            'categories' => $storeCategories]);
    }
}
