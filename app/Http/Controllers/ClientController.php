<?php

namespace App\Http\Controllers;

use App\Events\ClientCancelledOrder;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Revenue;
use App\Models\State;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $states;
    public function __construct()
    {
        $this->states = State::with('cities')->get();
    }
    public function home()
    {
        return view('Client.home');
    }
    public function profile()
    {
        return view('Client.profile');
    }
    public function balance()
    {
        $user = Auth::user();
        return view('client.client-balance', ['user' => $user]);
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

                $client = $user->client;
                $client->update([
                    'balance' => DB::raw('balance + ' . $voucher->value),
                ]);
                $voucher->update([
                    'status' => 'used',

                ]);
                $voucher->user()->associate($client);
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
        $clients = Client::with('user')->paginate();
        // $states = State::with('cities')->get();
        return view('Admin.Clients.clients-index', ['clients' => $clients, 'states' => $this->states]);
    }
    public function filter(Request $request)
    {

        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $state_id = $request->state_id ?? 'all';
        $city_id = $request->city_id ?? '';
        $status = $request->status ?? ['Active', 'Banned'];
        $sort = $request->sort ?? 'newest';
        $query = Client::query();

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

            if (!empty($status)) {
                $userQuery->whereIn('status', $status);
            }
            if ($state_id != 'all') {
                $userQuery->where('state_id', '=', $state_id);

                if ($city_id != 'all') {
                    $userQuery->where('city_id', '=', $city_id);

                }
            }
        });

        // Apply the order by clause
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $clients = $query->with('user')->paginate();

        return view('Admin.Clients.clients-index', ['clients' => $clients, 'states' => $this->states]);

    }
    public function show($id)
    {
        $user = User::where('type', '=', 'Client')->with(['client'])->findOrFail($id);
        return view('Admin.Clients.clients-show', ['user' => $user]);
    }
    public function ban($id)
    {
        $client = User::where('type', '=', 'Client')->findOrFail($id);
        if ($client->status == 'Banned') {
            return redirect()->back()->with('error', 'This Client Is Already Banned');

        }
        $orders = $client->client->orders()->whereIn('status', ['pending', 'ready', 'accepted'])->get();
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
                $client->client->balance = DB::raw('balance +' . ($amount - $refund['value']));
                $client->client->save();

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
            }
            DB::commit();
            $client->status = 'Banned';
            $client->save();
            return redirect()->back()->with('success', 'Client Banned Successfully');
        }
        $client->status = 'Banned';
        $client->save();
        return redirect()->back()->with('success', 'Client Banned Successfully');

    }
    public function activate($id)
    {
        $client = User::where('type', '=', 'Client')->findOrFail($id);
        if ($client->status == 'Active') {
            return redirect()->back()->with('error', 'This Client Is Already Active');

        }
        $client->status = 'Active';
        $client->save();
        return redirect()->back()->with('success', 'Client Activated Successfully');
    }
}
