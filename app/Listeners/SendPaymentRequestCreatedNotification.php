<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\PaymentRequestCreatedNotification;

class SendPaymentRequestCreatedNotification
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
        $admin->notify(new PaymentRequestCreatedNotification($event->paymentRequest));
    }
}
