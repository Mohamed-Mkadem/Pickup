<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate();
        if ($user->type == 'Admin') {
            return view('admin.notifications-index', ['notifications' => $notifications]);
        } elseif ($user->type == 'Seller') {
            return view('Seller.seller-notifications-index', ['notifications' => $notifications]);
        } else {
            return view('Client.client-notifications-index', ['notifications' => $notifications]);

        }
    }
    public function filter(Request $request)
    {
        $user = Auth::user();
        if ($request->status == 'unread') {
            $notifications = $user->unreadNotifications()->paginate();
        } elseif ($request->status == 'read') {
            $notifications = $user->readNotifications()->paginate();
        } else {
            $notifications = $user->notifications()->paginate();

        }

        if ($user->type == 'Admin') {
            return view('admin.notifications-index', ['notifications' => $notifications]);
        } elseif ($user->type == 'Seller') {
            return view('Seller.seller-notifications-index', ['notifications' => $notifications]);
        } else {
            return view('Client.client-notifications-index', ['notifications' => $notifications]);

        }
    }
    // public function getLatestNotifications()
    // {
    //     $user = Auth::user();
    //     $notifications = $user->notifications()->take(4)->get();
    //     $unreadCount = $user->unreadNotifications()->count();
    //     return view('components.notification-menu', ['notifications' => $notifications, 'unreadCount' => $unreadCount]);
    // }
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->take(4)->get();

        return view('components.notification-menu', [
            'notifications' => $notifications,
            'unreadCount' => $user->unreadNotifications()->count(),
        ])->render();
    }
}
