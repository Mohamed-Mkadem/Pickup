<?php

namespace App\Listeners;

use App\Notifications\PaymentRequestRejectedNotification;

class SendPaymentRequestRejectedNotification
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
        $notifiable = $event->paymentRequest->seller->user;
        $notifiable->notify(new PaymentRequestRejectedNotification($event->paymentRequest));
    }
}
