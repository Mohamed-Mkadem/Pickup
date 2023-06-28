<?php

namespace App\Listeners;

use App\Notifications\VerificationRequestRejectedNotification;

class SendVerificationRequestRejectedNotification
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
        $user = $event->verificationRequest->seller->user;
        $user->notify(
            new VerificationRequestRejectedNotification($event->verificationRequest)
        );
    }
}
