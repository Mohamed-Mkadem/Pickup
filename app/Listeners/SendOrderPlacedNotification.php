<?php

namespace App\Listeners;

use App\Notifications\OrderPlacedNotification;

class SendOrderPlacedNotification
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

        $seller->notify(new OrderPlacedNotification($event->order));
    }
}
