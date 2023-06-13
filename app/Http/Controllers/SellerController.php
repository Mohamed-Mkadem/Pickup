<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
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
        $user = User::findOrFail(Auth::id());
        return view('Seller.seller-balance', ['user' => $user]);
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
}
