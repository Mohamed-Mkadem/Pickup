<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Rules\CategoryBelongsToStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // protected $messages = [
    //     'image' => 'The Image Must Be a square (aspect ratio of 1:1)',
    // ];
    protected $attributes = [
        'category_id' => 'Category',
        'brand_id' => 'Brand',
    ];
    public $brands;

    public function __construct()
    {

        $this->middleware('hasActiveStore')->only(['index', 'create', 'edit', 'show', 'store', 'filter']);
        $this->brands = Brand::where('status', 'active')->get();

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->seller->store->id)->with(['store', 'category', 'brand'])->orderBy('created_at', 'desc')->paginate();
        $store = Auth::user()->seller->store;

        $categories = Category::where('store_id', $store->id)->get();

        return view('Seller.Products.products-index', ['products' => $products, 'brands' => $this->brands, 'categories' => $categories]);
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
        $categories = $request->categories ?? [];
        $brands = $request->brands ?? [];
        $statuses = $request->statuses ?? [];
        $units = $request->units ?? [];
        $sort = $request->sort ?? '';
        $stock_statuses = $request->stock_statuses ?? [];
        $query->where('store_id', $store->id);
        // dd($brands);
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
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
        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
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

        return view('Seller.Products.products-index', ['products' => $products, 'brands' => $this->brands, 'categories' => $storeCategories]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = Auth::user()->seller->store;

        $categories = Category::where('store_id', $store->id)->get();

        return view('Seller.Products.products-create', ['store' => $store, 'brands' => $this->brands, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = Auth::user()->seller->store;
        $validation = Validator::make($request->all(), [
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id', new CategoryBelongsToStore($request->category_id, $store->id)],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'cost_price' => ['required', 'numeric', 'min:0.05'],
            'price' => ['required', 'numeric', 'gt:cost_price'],
            'stock_alert' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
            'unit' => ['required', 'in:weight,piece,liquid'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048', Rule::dimensions()->height(500)->width(500)],
            'info' => ['string', 'nullable'],
            'ingredients' => ['string', 'nullable'],
        ], [], $this->attributes);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('/products', [
                    'disk' => 'public',
                ]);

            }

            $product = new Product();
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->status = $request->status;
            $product->store_id = $store->id;
            $product->name = $request->name;
            $product->cost_price = $request->cost_price;
            $product->price = $request->price;
            $product->stock_alert = $request->stock_alert;
            $product->quantity = $request->quantity;
            $product->unit = $request->unit;
            $product->description = $request->description;
            $product->info = $request->info ?? null;
            $product->ingredients = $request->ingredients ?? null;
            if ($path) {
                $product->image = $path;
            }
            $product->save();
            return redirect()->back()->with('success', 'Product Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $store = Auth::user()->seller->store;
        $product = Product::
            where('store_id', $store->id)
            ->with(['category', 'brand', 'store'])
            ->findOrFail($id);

        return view('Seller.Products.products-show', ['product' => $product]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with(['store', 'category', 'brand'])->findOrFail($id);

        $this->authorize('update', $product);
        $store = Auth::user()->seller->store;

        $categories = Category::where('store_id', $store->id)->get();
        return view('Seller.Products.products-edit', ['product' => $product, 'brands' => $this->brands, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::with(['store', 'category', 'brand'])->findOrFail($id);

        $store = Auth::user()->seller->store;
        $this->authorize('update', $product);
        $validation = Validator::make($request->all(), [
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id', new CategoryBelongsToStore($request->category_id, $store->id)],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'cost_price' => ['required', 'numeric', 'min:0.05'],
            'price' => ['required', 'numeric', 'gt:cost_price'],
            'stock_alert' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
            'unit' => ['required', 'in:weight,piece,liquid'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'image' => ['image', 'mimes:jpg,jpeg', 'max:2048', Rule::dimensions()->height(500)->width(500)],
            'info' => ['string', 'nullable'],
            'ingredients' => ['string', 'nullable'],
        ], [], $this->attributes);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('/products', [
                    'disk' => 'public',
                ]);

            }

            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->status = $request->status;
            $product->name = $request->name;
            $product->cost_price = $request->cost_price;
            $product->price = $request->price;
            $product->stock_alert = $request->stock_alert;
            $product->quantity = $request->quantity;
            $product->unit = $request->unit;
            $product->description = $request->description;
            $product->info = $request->info ?? null;
            $product->ingredients = $request->ingredients ?? null;
            if ($path) {
                $product->image = $path;
            }
            $product->save();
            return redirect()->back()->with('success', 'Product Updated Successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        /*
        - The deletion logic
        --- if the product exist in sales,or orders, it will be soft deleted,else it will be hard Deleted
        --- When You create the orders and sales use the delete and forcedelete

         */
        // dd($product->inCarts());
        if ($product->inCarts()) {
            $carts = $product->carts;
            foreach ($carts as $cart) {
                foreach ($cart->products as $cart_product) {
                    if ($cart_product->cart_products->product_id == $product->id) {
                        $cart_product->cart_products->delete();
                    }
                    $product->forceDelete();
                }
            }
        }
        if (!$product->hasOrders() && !$product->hasSales()) {
            $product->forceDelete();

        } else {
            $product->delete();
        }
        return redirect()->route('seller.products.index')->with('success', 'Product Deleted Successfully');
    }
    public function populate()
    {
        // Get all the stores
        $stores = Store::all();

// Iterate over each store
        foreach ($stores as $store) {
            // Calculate the start and end category IDs for the current store
            $startCategoryId = ($store->id - 1) * 5 + 1;
            $endCategoryId = $startCategoryId + 4;

            // Generate 5 products for each category within the store's range
            for ($categoryId = $startCategoryId; $categoryId <= $endCategoryId; $categoryId++) {
                // Iterate 5 times to create 5 products for each category
                for ($i = 0; $i < 5; $i++) {
                    // Generate random data for the product

                    $name = fake()->name();
                    $brandId = mt_rand(1, 20);
                    $status = 'active';
                    $array = ['weight', 'piece', 'liquid'];
                    $index = array_rand($array, 1);
                    $unit = $array[$index];
                    $stockAlert = mt_rand(10, 50);
                    $costPrice = mt_rand(10, 100);
                    $price = mt_rand(100, 500);
                    $quantity = mt_rand(10, 100);
                    $description = fake()->paragraphs(2, true);
                    $info = fake()->paragraphs(2, true);
                    $ingredients = fake()->paragraphs(2, true);
                    $image = 'products/default.jpg';

                    // Create the product record
                    $product = new Product();
                    $product->name = $name;
                    $product->store_id = $store->id;
                    $product->category_id = $categoryId;
                    $product->brand_id = $brandId;
                    $product->status = $status;
                    $product->unit = $unit;
                    $product->stock_alert = $stockAlert;
                    $product->cost_price = $costPrice;
                    $product->price = $price;
                    $product->quantity = $quantity;
                    $product->description = $description;
                    $product->info = $info;
                    $product->ingredients = $ingredients;
                    $product->image = $image;
                    $product->save();
                }
            }
        }
    }
}
