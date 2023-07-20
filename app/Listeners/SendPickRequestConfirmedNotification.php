<?php

namespace App\Listeners;

use App\Notifications\PickRequestConfirmedNotification;

class SendPickRequestConfirmedNotification
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
        $seller = $pickRequest->order->store->owner->user;
        $seller->notify(new PickRequestConfirmedNotification($pickRequest));
    }
}
