<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\State;
use App\Models\User;
use App\Models\Voucher;
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
        $user = User::where('type', '=', 'Client')->findOrFail($id);
        return view('Admin.Clients.clients-show', ['user' => $user]);
    }
    public function ban($id)
    {
        $client = User::where('type', '=', 'Client')->findOrFail($id);
        if ($client->status == 'Banned') {
            return redirect()->back()->with('error', 'This Client Is Already Banned');
            dd($client->status);
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
