<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\TicketSubmittedNotification;

class SendTicketSubmittedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admin = User::where('type', 'Admin')->firstOrFail();
        $admin->notify(new TicketSubmittedNotification($event->ticket));
    }
}
