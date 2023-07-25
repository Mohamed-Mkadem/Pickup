<?php

namespace App\Http\Controllers;

use App\Events\SellerCancelledOrder;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\State;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    protected $states;
    public function __construct()
    {
        $this->states = State::with('cities')->get();
    }
    public function home()
    {
        // dd(Auth::id());
        // $vouchers = Auth::user()->seller->vouchers;
        $vouchers = Voucher::where('user_id', Auth::user()->seller->id)->get();
        // dd($vouchers);
        return view('Seller.home', ['vouchers' => $vouchers]);
        // return view('Seller.home');
    }
    public function profile()
    {
        return view('seller.profile');
    }
    public function balance()
    {
        // $user = User::findOrFail(Auth::id());
        $seller = Seller::where('user_id', Auth::id())->with('store')->first();

        return view('Seller.seller-balance', ['seller' => $seller]);
    }
    public function topUp(Request $request)
    {

        $request->validate([
            'code' => ['required', 'numeric', 'digits:14'],
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if ($voucher) {
            if ($voucher->status == 'unused') {

                $user = User::findOrFail(Auth::id());

                $seller = $user->seller;
                $seller->update([
                    'balance' => DB::raw('balance + ' . $voucher->value),
                ]);
                $voucher->update([
                    'status' => 'used',

                ]);
                $voucher->user()->associate($seller);
                $voucher->save();

                return redirect()->back()->with('success', 'Balance Added successfully');
            } else {

                return redirect()->back()->with('error', 'This Voucher Is Already Used');
            }
        } else {
            return redirect()->back()->with('error', 'The Entered Code Is Wrong!');

        }

    }

    public function index()
    {
        $sellers = Seller::with('user')->paginate();
        return view('Admin.Sellers.sellers-index', ['sellers' => $sellers, 'states' => $this->states]);
    }
    public function filter(Request $request)
    {

        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $state_id = $request->state_id ?? 'all';
        $city_id = $request->city_id ?? '';
        $status = $request->status ?? ['Active', 'Banned'];
        $verification = $request->verification ?? ['Verified', 'Unverified'];
        $sort = $request->sort ?? 'newest';
        $query = Seller::query();

        $query->whereHas('user', function ($userQuery) use ($search, $minDate, $maxDate, $status, $state_id, $city_id) {
            if (!empty($minDate)) {
                $userQuery->where('created_at', '>=', $minDate);
            }

            if (!empty($maxDate)) {
                $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
                $userQuery->where('created_at', '<=', $maxDateTime);
            }

            if (!empty($search)) {
                $userQuery->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                ;
            }

            $userQuery->whereIn('status', $status);

            if ($state_id != 'all') {
                $userQuery->where('state_id', '=', $state_id);

                if ($city_id != 'all') {
                    $userQuery->where('city_id', '=', $city_id);

                }
            }
        });
        $query->whereIn('verification', $verification);
        // Apply the order by clause
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $sellers = $query->with('user')->paginate();

        return view('Admin.Sellers.sellers-index', ['sellers' => $sellers, 'states' => $this->states]);

    }
    public function show($id)
    {
        $user = User::where('type', '=', 'Seller')
            ->with('seller.store', 'seller.store.sector', 'seller.paymentRequests', 'seller.verificationRequests')
            ->findOrFail($id);

        // dd($user);
        return view('Admin.Sellers.sellers-show', ['user' => $user]);
    }
    public function ban($id)
    {
        $seller = User::where('type', '=', 'Seller')->findOrFail($id);
        if ($seller->status == 'Banned') {
            return redirect()->back()->with('error', 'This Seller Is Already Banned');
        }
        $store = $seller->seller->store()->where('status', '!=', 'banned')->first();
        if (!$store) {
            $seller->status = 'Banned';
            $seller->save();
            return redirect()->back()->with('success', 'Seller Banned Successfully');
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
            $seller->status = 'Banned';
            $seller->save();
            return redirect()->back()->with('success', 'Seller Banned Successfully');
            DB::commit();

        }
        $seller->status = 'Banned';
        $seller->save();
        return redirect()->back()->with('success', 'Seller Banned Successfully');

    }
    public function activate($id)
    {
        $seller = User::where('type', '=', 'Seller')->findOrFail($id);
        if ($seller->status == 'Active') {
            return redirect()->back()->with('error', 'This Seller Is Already Active');

        }
        $seller->status = 'Active';
        $seller->save();
        return redirect()->back()->with('success', 'Seller Activated Successfully');
    }
}
