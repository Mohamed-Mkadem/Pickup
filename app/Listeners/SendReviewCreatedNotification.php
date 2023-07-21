<?php

namespace App\Listeners;

use App\Notifications\ReviewCreatedNotification;

class SendReviewCreatedNotification
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
        $seller = $event->review->store->owner->user;
        $seller->notify(new ReviewCreatedNotification($event->review));
    }
}
