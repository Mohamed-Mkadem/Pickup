<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EarningController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        // dd($user->getEarningStatistics());
        $expensesCategories = DB::table('expenses')
            ->select('category', DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', $user->id)
            ->groupBy('category')
            ->orderBy('total_amount', 'desc')
            ->get();
        $revenuesCategories = DB::table('revenues')
            ->select('category', DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', $user->id)
            ->groupBy('category')
            ->orderBy('total_amount', 'desc')
            ->get();

        if ($user->isSeller()) {

            return view('Seller.seller-earnings', ['expenses' => $expensesCategories, 'revenues' => $revenuesCategories]);
        }
        return view('Admin.earnings', ['expenses' => $expensesCategories, 'revenues' => $revenuesCategories]);
    }
}
