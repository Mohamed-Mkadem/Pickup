<?php

namespace App\Listeners;

use App\Models\PickRequest;
use App\Notifications\PickRequestCreatedNotification;

class SendPickRequestCreatedNotification
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
        $pickRequest = $event->pickRequest;
        $client = $pickRequest->order->client->user;
        $client->notify(new PickRequestCreatedNotification($pickRequest));
    }
}
