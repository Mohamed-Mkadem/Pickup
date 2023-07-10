<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public $attributes = [
        'amount.max' => 'Insufficient Balance',

    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::where('seller_id', Auth::user()->seller->id)->with(['store', 'seller'])->paginate();
        $store = Auth::user()->seller->store;

        return view('Seller.seller-transfers-index', ['transfers' => $transfers, 'store' => $store]);
    }
    public function adminIndex()
    {
        $transfers = Transfer::with(['store', 'seller'])->paginate();
        return view('Admin.transfers-index', ['transfers' => $transfers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seller = Auth::user()->seller;
        $store = $seller->store;
        $availableAmount = $store->balance;
        $validation = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', "max:$availableAmount"],
        ], $this->attributes);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        } else {
            DB::beginTransaction();
            $transfer = Transfer::create([
                'seller_id' => $seller->id,
                'store_id' => $store->id,
                'amount' => $request->amount,
            ]);

            $store->balance = DB::raw('balance - ' . $request->amount);
            $store->save();
            $seller->balance = DB::raw('balance +' . $request->amount);
            $seller->save();

            DB::commit();
            return redirect()->back()->with('success', "$request->amount TND Transfered Successfully To Your Balance");

        }
    }
    public function filter(Request $request)
    {
        $query = Transfer::query();
        $user = Auth::user();
        if ($user->type == 'Seller') {
            $query->where('seller_id', $user->seller->id);
        }

        $search = $request->search ?? '';
        $sort = $request->sort ?? 'newest';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
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
        } elseif ($sort === 'highest amount') {
            $query->orderBy('amount', 'desc');
        } elseif ($sort === 'lowest amount') {
            $query->orderBy('amount', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $transfers = $query->with(['seller', 'store'])->paginate();
        if ($user->type == 'Seller') {
            $store = $user->seller->store;

            return view('Seller.seller-transfers-index', ['transfers' => $transfers, 'store' => $store]);
        } else {
            return view('Admin.transfers-index', ['transfers' => $transfers]);
        }
    }

    public function transfers($username)
    {
        $store = Store::where('username', $username)->first();

        if (!$store) {
            abort(404);
        }
        $transfers = $store->transfers()->with('seller')->orderBy('created_at', 'desc')->paginate();
        return view('Admin.Stores.show_store_transfers', ['store' => $store, 'transfers' => $transfers]);
    }
    public function transfersFilter(Request $request, $username)
    {
        $store = Store::where('username', $username)->first();

        if (!$store) {
            abort(404);
        }
        $query = Transfer::query();
        $query->where('store_id', $store->id);

        $search = $request->search ?? '';
        $sort = $request->sort ?? 'newest';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
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
        } elseif ($sort === 'highest amount') {
            $query->orderBy('amount', 'desc');
        } elseif ($sort === 'lowest amount') {
            $query->orderBy('amount', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $transfers = $query->with(['seller'])->paginate();
        return view('Admin.Stores.show_store_transfers', ['store' => $store, 'transfers' => $transfers]);

    }
}
