<?php

namespace App\Listeners;

use App\Notifications\OrderReadyNotification;

class SendOrderReadyNotification
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
        $client->notify(new OrderReadyNotification($event->order));
    }
}
