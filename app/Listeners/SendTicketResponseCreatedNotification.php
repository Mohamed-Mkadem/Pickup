<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\TicketResponseCreatedNotification;

class SendTicketResponseCreatedNotification
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
        $sender = $event->sender;
        $notifiable = $event->ticket->user;
        if (!$sender->isAdmin()) {
            $admin = User::where('type', 'Admin')->first();
            $notifiable = $admin;
        }
        $notifiable->notify(new TicketResponseCreatedNotification($event->sender, $event->ticket));
    }
}
