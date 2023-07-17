<?php

namespace App\Listeners;

use App\Notifications\ClientCancelledOrderNotification;

class SendClientCancelledOrderNotification
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

        $seller->notify(new ClientCancelledOrderNotification($event->order, $event->status, $event->refund));
    }
}
