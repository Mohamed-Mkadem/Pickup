<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        $sellersTodayCount = User::where('type', 'Seller')->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count();
        $sellersYesterdayCount = User::where('type', 'Seller')->whereBetween('created_at', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->count();

        $sellers = [
            'todayCount' => $sellersTodayCount,
            'yesterdayCount' => $sellersYesterdayCount,
            'difference' => $sellersTodayCount - $sellersYesterdayCount,
        ];
        $clientsTodayCount = User::where('type', 'Client')->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count();
        $clientsYesterdayCount = User::where('type', 'Client')->whereBetween('created_at', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->count();

        $clients = [
            'todayCount' => $clientsTodayCount,
            'yesterdayCount' => $clientsYesterdayCount,
            'difference' => $clientsTodayCount - $clientsYesterdayCount,
        ];

        $user = Auth::user();

        $todayCount = $user->notifications()
            ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->count();

        $yesterdayCount = $user->notifications()
            ->whereBetween('created_at', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])
            ->count();

        $notificationStatistics = [
            'todayCount' => $todayCount,
            'yesterdayCount' => $yesterdayCount,
            'difference' => $todayCount - $yesterdayCount,
        ];

        return view('Admin.home', ['sellers' => $sellers, 'clients' => $clients, 'notifications' => $notificationStatistics]);
    }
    public function profile()
    {
        return view('Admin.profile');
    }
}
