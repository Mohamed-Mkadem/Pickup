<?php

namespace App\Http\Controllers;

use App\Events\SellerCancelledOrder;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use App\Models\Sector;
use App\Models\Seller;
use App\Models\State;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    protected $attributes = [
        'openingHours.monday.closing_time.after' => 'The closing time on Monday must be after the opening time.',
        'openingHours.tuesday.closing_time.after' => 'The closing time on Tuesday must be after the opening time.',
        'openingHours.wednesday.closing_time.after' => 'The closing time on Wednesday must be after the opening time.',
        'openingHours.thursday.closing_time.after' => 'The closing time on Thursday must be after the opening time.',
        'openingHours.friday.closing_time.after' => 'The closing time on Friday must be after the opening time.',
        'openingHours.saturday.closing_time.after' => 'The closing time on Saturday must be after the opening time.',
        'openingHours.sunday.closing_time.after' => 'The closing time on Sunday must be after the opening time.',
        'username.one_word' => 'The Username Field Must be One Word',
    ];
    protected $states;
    protected $sectors;
    protected $covers;
    protected $fileNames;
    protected $brands;
    public function __construct()
    {

        $this->middleware('isVerified')->only(['create', 'index']);
        // $this->brands = Brand::where('status', 'active')->get();
        $this->brands = Brand::get();
        $this->states = State::with('cities')->get();
        // $this->sectors = Sector::where('status', 'active')->get();
        $this->sectors = Sector::get();
        $this->covers = Storage::files('public/stores/covers');
        $this->fileNames = array_map(function ($file) {
            return File::basename($file);
        }, $this->covers);
        // dd($this->fileNames);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = User::find(Auth::id());
        // dd($user->seller->isVerified() && $user->seller->hasStore());
        $stores = Store::where('seller_id', Auth::user()->seller->id)->with(['owner', 'sector'])->get();
        return view(
            'Seller.Stores.stores-index', ['stores' => $stores]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = Seller::with('user')->find(Auth::user()->seller->id);
        // $this->authorize('create', Store::class);
        return view('Seller.Stores.stores-create', ['seller' => $seller, 'states' => $this->states, 'sectors' => $this->sectors, 'covers' => $this->covers, 'fileNames' => $this->fileNames]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Store::class);
        Validator::extend('one_word', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\w+$/', $value);
        });

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'max:60', 'unique:stores', 'string'],
            'sector_id' => ['required', 'exists:sectors,id'],
            'address' => ['required', 'string'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                $query->where('state_id', $request->state_id);
            })],
            'bio' => ['required', 'string', 'max:400'],
            'username' => ['required', 'unique:stores', 'max:20', 'one_word'],
            'phone' => ['required', 'digits:8'],
            'photo' => ['required', 'file', 'image', 'mimes:jpg,jpeg', 'max:1024', Rule::dimensions()->height(256)->width(256)],
            'cover' => ['string'],
            'openingHours' => ['required', 'array'],
            'openingHours.*.opening_time' => ['required', 'date_format:H:i'],
            'openingHours.*.closing_time' => ['required', 'date_format:H:i', 'after:openingHours.*.opening_time'],
        ], $this->attributes);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            DB::beginTransaction();

            $file = $request->file('photo');
            $path = $file->store('/stores/photos', [
                'disk' => 'public',
            ]);

            $store = new Store;
            $store->name = $request->name;
            $store->seller_id = Auth::user()->seller->id;
            $store->username = $request->username;
            $store->bio = $request->bio;
            $store->state_id = $request->state_id;
            $store->city_id = $request->city_id;
            $store->phone = $request->phone;
            $store->address = $request->address;
            $store->sector_id = $request->sector_id;

            if ($path) {
                $store->photo = $path;
            }

            if ($request->cover) {
                $store->cover_photo = $request->cover;
            }

            $store->save();
            foreach ($request->openingHours as $day => $hours) {
                $openingHours = new StoreOpeningHour();
                $openingHours->day_of_week = $day;
                $openingHours->opening_time = $hours['opening_time'];
                $openingHours->closing_time = $hours['closing_time'];
                $openingHours->store_id = $store->id;
                $openingHours->save();
            }
            DB::commit();

            return redirect()->back()->with('success', 'Store Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($username)
    {
        $store = Store::where('username', $username)->with(['owner', 'sector', 'openingHours'])->first();
        $this->authorize('view', $store);
        // dd($store->openingHours->where('day_of_week', 'friday'));
        return view('Seller.Stores.stores-show', ['store' => $store]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($username)
    {

        $store = Store::where('username', $username)->with(['owner', 'sector', 'openingHours'])->first();

        $this->authorize('update', $store);
        return view('Seller.Stores.stores-edit', ['store' => $store, 'states' => $this->states, 'sectors' => $this->sectors, 'covers' => $this->covers, 'fileNames' => $this->fileNames]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $store = Store::findOrFail($id);
        // if (!$store) {
        //     return redirect()->back()->with('Cannot Update This Store');
        // }
        $this->authorize('update', $store);
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'max:60', 'string', Rule::unique('stores', 'name')->ignore($store->id)],
            'sector_id' => ['required', 'exists:sectors,id'],
            'address' => ['required', 'string'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                $query->where('state_id', $request->state_id);
            })],
            'bio' => ['required', 'string', 'max:400'],

            'phone' => ['required', 'digits:8'],
            'photo' => ['file', 'image', 'mimes:jpg,jpeg', 'max:1024', Rule::dimensions()->height(256)->width(256)],
            'cover' => ['string'],
            'openingHours' => ['required', 'array'],
            'openingHours.*.opening_time' => ['required', 'date_format:H:i'],
            'openingHours.*.closing_time' => ['required', 'date_format:H:i', 'after:openingHours.*.opening_time'],
        ], $this->attributes);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            DB::beginTransaction();
            $path = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $path = $file->store('/stores/photos', [
                    'disk' => 'public',
                ]);
            }

            $store->name = $request->name;
            // dd($store->city_id);
            // dd($request->city_id);
            $store->bio = $request->bio;
            $store->state_id = $request->state_id;
            $store->city_id = $request->city_id;
            $store->phone = $request->phone;
            $store->address = $request->address;
            $store->sector_id = $request->sector_id;

            if ($path) {
                $store->photo = $path;
            }

            if ($request->cover) {
                $store->cover_photo = $request->cover;
            }

            $store->save();

            foreach ($request->openingHours as $day => $hours) {
                $dayOpeningHours = $store->openingHours()->where('day_of_week', $day)->first();
                $dayOpeningHours->opening_time = $hours['opening_time'];

                $dayOpeningHours->closing_time = $hours['closing_time'];
                $dayOpeningHours->save();
            }
            DB::commit();

            return redirect()->back()->with('success', 'Store Updated Successfully');
        }

    }

    public function enableMaintenance($id)
    {
        $store = Store::findOrFail($id);
        $this->authorize('update', $store);
        return redirect()->back()->with('success', 'Maintenance Mode Enabled Successfully');
        if ($store->status == 'published') {
            $store->status = 'maintenance';
            $store->save();
            return redirect()->back()->with('success', 'Maintenance Mode Enabled Successfully');
        } else {
            return redirect()->back()->with('error', 'Cannot Enable The Maintenance Mode for this Store');
        }
    }
    public function disableMaintenance($id)
    {
        $store = Store::findOrFail($id);
        $this->authorize('update', $store);
        if ($store->status == 'maintenance') {
            $store->status = 'published';
            $store->save();
            return redirect()->back()->with('success', 'Maintenance Mode Disabled Successfully');
        } else {
            return redirect()->back()->with('error', 'Cannot Disable The Maintenance Mode for this Store');
        }
    }

    // Admin Methods
    public function adminIndex()
    {
        // Sectors, states, cities,
        $stores = Store::with(['sector', 'city'])->orderBy('created_at', 'DESC')->paginate();

        return view('Admin.Stores.admin-stores-index', ['stores' => $stores, 'states' => $this->states, 'sectors' => $this->sectors]);
    }
    public function filter(Request $request)
    {
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? [];
        $state_id = $request->state_id ?? 'all';
        $city_id = $request->city_id ?? 'all';
        $min_balance = $request->min_balance ?? '';
        $max_balance = $request->max_balance ?? '';
        $min_rate = $request->min_rate ?? '';
        $max_rate = $request->max_rate ?? '';
        $min_followers = $request->min_followers ?? '';
        $max_followers = $request->max_followers ?? '';
        $sectors = $request->sectors ?? [];
        $sort = $request->sort ?? 'newest';

        $query = Store::query();

        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if (!empty($min_balance)) {
            $query->where('balance', '>=', $min_balance);
        }

        if (!empty($max_balance)) {
            $query->where('balance', '<=', $max_balance);
        }
        if (!empty($min_followers)) {
            $query->where('followers', '>=', $min_followers);
        }

        if (!empty($max_followers)) {
            $query->where('followers', '<=', $max_followers);
        }
        if (!empty($min_rate)) {
            $query->where('rate', '>=', $min_rate);
        }

        if (!empty($max_rate)) {
            $query->where('rate', '<=', $max_rate);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        if (!empty($status)) {
            $query->whereIn('status', $status);
        }
        if (!empty($sectors)) {
            $query->whereIn('sector_id', $sectors);
        }

        if ($state_id != 'all') {
            $query->where('state_id', $state_id);
            if ($city_id != 'all') {
                $query->where('city_id', $city_id);

            }

        }

        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'highest rate') {
            $query->orderBy('rate', 'desc');
        }
        if ($sort == 'lowest rate') {
            $query->orderBy('rate', 'asc');
        }
        if ($sort == 'highest followers') {
            $query->orderBy('followers', 'desc');
        }
        if ($sort == 'lowest followers') {
            $query->orderBy('followers', 'asc');
        }
        if ($sort == 'highest balance') {
            $query->orderBy('balance', 'desc');
        }
        if ($sort == 'lowest balance') {
            $query->orderBy('balance', 'asc');
        }

        $stores = $query->with(['sector', 'city'])->paginate();

        return view('Admin.Stores.admin-stores-index', ['stores' => $stores, 'states' => $this->states, 'sectors' => $this->sectors]);
    }

    public function home($username)
    {
        $store = Store::where('username', $username)->with(['owner.user', 'sector', 'city', 'openingHours', 'transfers'])->first();
        // $owner = $store->owner->user;
        // dd($owner);
        if (!$store) {
            abort(404);
        }
        // dd($store->salesThisMonth());
        // dd($store->openingHours);
        return view('Admin.Stores.show_store_home', ['store' => $store]);
    }
    public function owner($username)
    {
        $store = Store::where('username', $username)->with(['owner.user', 'owner.verificationRequests', 'sector', 'city'])->first();
        if (!$store) {
            abort(404);
        }
        return view('Admin.Stores.show_store_owner', ['store' => $store]);
    }
    public function reviews($username)
    {

        $store = Store::where('username', $username)->with('reviews')->firstOrFail();
        $user = Auth::user();

        $reviews = Review::where('store_id', $store->id)->with(['client', 'order'])->paginate();

        if ($user->type == 'Admin') {
            return view('Admin.Stores.show_store_reviews', ['store' => $store, 'reviews' => $reviews]);
        }
        if ($user->type == 'Client') {
            return view('Client.Stores.client_store_reviews', ['store' => $store, 'reviews' => $reviews]);
        }
    }
    public function ban($id)
    {
        $store = Store::findOrFail($id);

        if ($store->status == 'banned') {
            return redirect()->back()->with('error', 'This Store Is Already Banned');
        }
        $orders = $store->orders()->whereIn('status', ['pending', 'ready', 'accepted'])->get();

        if ($orders) {
            DB::beginTransaction();
            foreach ($orders as $order) {

                $refund = [
                    'percentage' => '0%',
                    'value' => 0,
                ];
                $status = $order->status;
                $amount = $order->amount;

                if ($status == 'accepted') {
                    $refund['percentage'] = '10%';
                    $refund['value'] = ($amount / 100) * 10;
                }
                if ($status == 'ready') {
                    $refund['percentage'] = '20%';
                    $refund['value'] = ($amount / 100) * 20;
                }

                // Change Order's status
                $order->status = 'cancelled';
                $order->save();

                // Return Money to the client
                $order->client->balance = DB::raw('balance +' . ($amount + $refund['value']));
                $order->client->save();

                // Update products Quantity
                foreach ($order->products as $product) {
                    $product->increment('quantity', $product->order_products->quantity);

                }
                // Add The Event
                event(new SellerCancelledOrder($order, $status, $refund, true));

                // Add Status History
                $order->statusHistories()->create([
                    'statusable_type' => 'App\Models\Order',
                    'statusable_id' => $order->id,
                    'action' => 'Cancelled',
                ]);
            }
            $store->status = 'banned';
            $store->save();
            DB::commit();
            return redirect()->back()->with('success', 'Store Banned Successfully');
        }

        $store->status = 'banned';
        $store->save();
        return redirect()->back()->with('success', 'Store Banned Successfully');

    }
    public function activate($id)
    {
        $store = Store::findOrFail($id);

        if ($store->status != 'banned') {
            return redirect()->back()->with('error', 'This Store Is Already Active');
        }
        $currentDate = date('Y-m-d');

        if ($store->expiry_date >= $currentDate) {

            $store->status = 'maintenance';
            $store->save();

            return redirect()->back()->with('success', 'Store Returned To Maintenance Mode Successfully');
        } else {

            $store->status = 'unpublished';
            $store->save();

            return redirect()->back()->with('success', 'Store Activated Successfully');

        }

    }
    public function orders($username)
    {
        $store = Store::where('username', $username)->firstOrFail();

        $orders = Order::where('store_id', $store->id)->orderBy('created_at', 'desc')->paginate();

        return view('Admin.Stores.show_store_orders', ['store' => $store, 'orders' => $orders]);
    }

    public function order($username, $id)
    {
        $store = Store::where('username', $username)->firstOrFail();
        // dd($store);
        $order = Order::where('store_id', $store->id)->findOrFail($id);

        $products = OrderProduct::where('order_id', $order->id)->paginate();
        return view('Admin.Stores.show_store_order', ['order' => $order, 'products' => $products, 'store' => $store]);
    }
    // Client Methods

    public function clientIndex()
    {

        $stores = Store::where('status', 'published')->with(['sector', 'city'])->orderBy('rate', 'DESC')->paginate();

        return view('Client.Stores.client-stores-index', ['stores' => $stores, 'states' => $this->states, 'sectors' => $this->sectors]);
    }
    public function clientFilter(Request $request)
    {
        $client = Client::where('user_id', Auth::id())->first();
        $search = $request->search ?? '';
        $state_id = $request->state_id ?? 'all';
        $city_id = $request->city_id ?? 'all';
        $min_rate = $request->min_rate ?? '';
        $max_rate = $request->max_rate ?? '';
        $min_followers = $request->min_followers ?? '';
        $max_followers = $request->max_followers ?? '';
        $sectors = $request->sectors ?? [];
        $statuses = $request->statuses ?? [];
        $sort = $request->sort ?? 'newest';

        $query = Store::query();
        $query->where('status', 'published');

        if (!empty($statuses)) {
            if (in_array('following', $statuses) && in_array('not following', $statuses)) {
                // Skip filtering if both checkboxes are checked
            } elseif (in_array('following', $statuses)) {
                $query->whereHas('follows', function ($subQuery) use ($client) {
                    $subQuery->where('client_id', $client->id);
                });
            } elseif (in_array('not following', $statuses)) {
                $query->whereDoesntHave('follows', function ($subQuery) use ($client) {
                    $subQuery->where('client_id', $client->id);
                });
            }
        }

        if (!empty($min_followers)) {
            $query->where('followers', '>=', $min_followers);
        }

        if (!empty($max_followers)) {
            $query->where('followers', '<=', $max_followers);
        }
        if (!empty($min_rate)) {
            $query->where('rate', '>=', $min_rate);
        }

        if (!empty($max_rate)) {
            $query->where('rate', '<=', $max_rate);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($sectors)) {
            $query->whereIn('sector_id', $sectors);
        }

        if ($state_id != 'all') {
            $query->where('state_id', $state_id);
            if ($city_id != 'all') {
                $query->where('city_id', $city_id);

            }

        }

        if ($sort == 'highest rate') {
            $query->orderBy('rate', 'desc');
        }
        if ($sort == 'lowest rate') {
            $query->orderBy('rate', 'asc');
        }
        if ($sort == 'highest followers') {
            $query->orderBy('followers', 'desc');
        }
        if ($sort == 'lowest followers') {
            $query->orderBy('followers', 'asc');
        }

        $stores = $query->with(['sector', 'city'])->paginate();
        return view('Client.Stores.client-stores-index', ['stores' => $stores, 'states' => $this->states, 'sectors' => $this->sectors]);
    }
    public function clientHome($username)
    {
        $store = Store::where('username', $username)->with(['sector', 'city', 'openingHours'])->first();
        // Handle the case where the store is unpublished / I will handle it on the view itself
        $products = $store->products()->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()->take(9)->get();

        if (!$store) {
            abort(404);
        }
        // dd($store->openingHours);
        return view('Client.Stores.client_store_home', ['store' => $store, 'products' => $products]);
    }
    public function clientProducts($username)
    {
        $store = Store::where('username', $username)->first();
        if (!$store) {
            abort(404);
        }
        $products = $store->products()
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->with('brand')
            ->orderBy('name', 'asc')
            ->paginate();
        $categories = $store->categories->where('status', 'active');

        return view('Client.Stores.client_store_products', [
            'products' => $products,
            'store' => $store,
            'brands' => $this->brands,
            'categories' => $categories]);
    }

    public function clientProduct($username, $id)
    {
        $store = Store::where('username', $username)->first();
        if (!$store) {
            abort(404);
        }
        $product = Product::where('store_id', $store->id)->where('status', 'active')->with(['category', 'brand'])->findOrFail($id);
        return view('Client.Stores.client_store_product', ['product' => $product, 'store' => $store]);
    }
    public function clientProductsFilter($username, Request $request)
    {
        $store = Store::where('username', $username)->first();
        if (!$store) {
            abort(404);
        }
        $query = Product::query();
        $query->where('store_id', $store->id);
        $query->where('status', 'active');
        $query->whereHas('category', function ($subQuery) {
            $subQuery->where('status', 'active');
        });

        $search = $request->search ?? '';
        $minPrice = $request->min_price ?? '';
        $maxPrice = $request->max_price ?? '';
        $categories = $request->categories ?? [];
        $brands = $request->brands ?? [];
        $sort = $request->sort ?? 'a-z';
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
        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        if ($sort == 'z-a') {
            $query->orderBy('name', 'desc');
        }
        if ($sort == 'a-z') {
            $query->orderBy('name', 'asc');
        }
        if ($sort == 'highest_sale_price') {
            $query->orderBy('price', 'desc');
        }
        if ($sort == 'lowest_sale_price') {
            $query->orderBy('price', 'asc');
        }
        // $products = $query->with('brand')->get();
        // dd($products);

        $products = $query->with('brand')->paginate();
        $storeCategories = $store->categories->where('status', 'active');
        return view('Client.Stores.client_store_products', [
            'products' => $products,
            'store' => $store,
            'brands' => $this->brands,
            'categories' => $storeCategories]);
    }

    public function cart($username)
    {
        $store = Store::where('username', $username)->first();
        if (!$store) {
            abort(404);
        }
        $client = Client::where('user_id', Auth::id())->first();
        if (!$client) {
            abort(404);
        }
        $cartInfo = Cart::where('store_id', $store->id)->where('client_id', $client->id)->first();

        $cartProducts = [];
        if ($cartInfo) {
            $cartProducts = json_encode(CartProduct::where('cart_id', $cartInfo->id)->get());

        }
        // dd($cartInfo);
        return view('Client.Stores.client_store_cart', ['cart' => $cartProducts, 'cartInfo' => $cartInfo, 'store' => $store]);
    }
    public function checkout($username)
    {
        $store = Store::where('username', $username)->firstOrFail();
        $client = Client::where('user_id', Auth::id())->firstOrFail();

        $cart = Cart::where('client_id', $client->id)->where('store_id', $store->id)->first();
        $cartProducts = [];
        if ($cart->products()) {
            $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
        }
        return view('Client.Stores.client_store_checkout', ['store' => $store, 'cart' => $cart, 'cartProducts' => $cartProducts]);
    }
    public function clientOrders($username)
    {
        $store = Store::where('username', $username)->firstOrFail();
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $orders = $client->orders()->where('store_id', $store->id)->orderBy('created_at', 'desc')->paginate();
        return view('Client.Stores.client_store_orders', ['orders' => $orders, 'store' => $store]);
    }

    public function clientOrder($username, $id)
    {
        $store = Store::where('username', $username)->firstOrFail();
        $client = Client::where('user_id', Auth::id())->firstOrFail();
        $order = Order::findOrFail($id);
        $products = OrderProduct::where('order_id', $order->id)->paginate();
        // dd($products);
        return view('Client.Stores.client_store_order', ['order' => $order, 'store' => $store, 'products' => $products]);
    }
    // public function clientReviews()
}
