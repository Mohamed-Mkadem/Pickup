<?php

namespace App\Listeners;

use App\Notifications\StoreUnpublishedNotification;

class StoreUnpublishedListener
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
        $owner = $event->owner;
        $owner->notify(new StoreUnpublishedNotification());
    }
}
