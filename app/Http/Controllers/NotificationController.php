<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate();
        if ($user->type == 'Admin') {
            return view('admin.notifications-index', ['notifications' => $notifications]);
        }
    }
}
