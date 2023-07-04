<?php

namespace App\Listeners;

use App\Models\PaymentRequest;
use App\Notifications\PaymentRequestAcceptedNotification;

class SendPaymentRequestAcceptedNotification
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
        $seller = $event->paymentRequest->seller->user;
        $seller->notify(new PaymentRequestAcceptedNotification($event->paymentRequest));
    }
}
