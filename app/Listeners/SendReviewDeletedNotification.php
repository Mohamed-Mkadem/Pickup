<?php

namespace App\Listeners;

use App\Notifications\ReviewDeletedNotification;

class SendReviewDeletedNotification
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
        $seller = $event->order->store->owner->user;
        $seller->notify(new ReviewDeletedNotification($event->order));
    }
}
