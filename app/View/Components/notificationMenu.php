<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class notificationMenu extends Component
{
    public $notifications;
    public $unreadCount;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();

        $this->notifications = $user->notifications()->take(4)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.notification-menu');
    }
}
