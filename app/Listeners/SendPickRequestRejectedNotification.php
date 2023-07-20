<?php

namespace App\Listeners;

use App\Notifications\PickRequestRejectedNotification;

class SendPickRequestRejectedNotification
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
        $seller->notify(new PickRequestRejectedNotification($pickRequest));
    }
}
