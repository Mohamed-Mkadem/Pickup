<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\VerificationRequestCreatedNotification;

class SendVerificationRequestCreatedNotification
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
        $admin = User::where('type', 'Admin')->first();
        // dd($admin);
        $admin->notify(new VerificationRequestCreatedNotification($event->verificationRequest, $event->seller));

    }
}
