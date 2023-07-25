<?php

namespace App\Listeners;

use App\Notifications\SellerCancelledOrderNotification;

class SendSellerCancelledOrderNotification
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
        $client = $event->order->client->user;
        $client->notify(new SellerCancelledOrderNotification($event->order, $event->status, $event->refund, $event->banned));
    }
}
