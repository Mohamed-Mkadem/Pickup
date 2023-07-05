<?php

namespace App\Providers;

use App\Events\PaymentRequestAccepted;
use App\Events\PaymentRequestCreated;
use App\Events\PaymentRequestPaid;
use App\Events\PaymentRequestRejected;
use App\Events\StoreUnpublished;
use App\Events\VerificationRequestApproved;
use App\Events\VerificationRequestCreated;
use App\Events\VerificationRequestRejected;
use App\Listeners\SendPaymentRequestAcceptedNotification;
use App\Listeners\SendPaymentRequestCreatedNotification;
use App\Listeners\SendPaymentRequestPaidNotification;
use App\Listeners\SendPaymentRequestRejectedNotification;
use App\Listeners\SendVerificationRequestApprovedNotification;
use App\Listeners\SendVerificationRequestCreatedNotification;
use App\Listeners\SendVerificationRequestRejectedNotification;
use App\Listeners\StoreUnpublishedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VerificationRequestCreated::class => [
            SendVerificationRequestCreatedNotification::class,
        ],
        VerificationRequestApproved::class => [
            SendVerificationRequestApprovedNotification::class,
        ],
        VerificationRequestRejected::class => [
            SendVerificationRequestRejectedNotification::class,
        ],
        StoreUnpublished::class => [
            StoreUnpublishedListener::class,
        ],
        PaymentRequestCreated::class => [
            SendPaymentRequestCreatedNotification::class,
        ],
        PaymentRequestAccepted::class => [
            SendPaymentRequestAcceptedNotification::class,
        ],
        PaymentRequestRejected::class => [
            SendPaymentRequestRejectedNotification::class,
        ],
        PaymentRequestPaid::class => [
            SendPaymentRequestPaidNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
