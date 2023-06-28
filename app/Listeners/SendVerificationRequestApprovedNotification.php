<?php

namespace App\Listeners;

use App\Notifications\VerificationRequestApprovedNotification;

class SendVerificationRequestApprovedNotification
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
            new VerificationRequestApprovedNotification($event->verificationRequest)
        );
    }
}
