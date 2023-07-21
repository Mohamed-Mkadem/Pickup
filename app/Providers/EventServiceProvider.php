<?php

namespace App\Providers;

use App\Events\ClientCancelledOrder;
use App\Events\OrderAccepted;
use App\Events\OrderPlaced;
use App\Events\OrderReady;
use App\Events\OrderRejected;
use App\Events\PaymentRequestAccepted;
use App\Events\PaymentRequestCreated;
use App\Events\PaymentRequestPaid;
use App\Events\PaymentRequestRejected;
use App\Events\PickRequestConfirmed;
use App\Events\PickRequestCreated;
use App\Events\PickRequestRejected;
use App\Events\ReviewCreated;
use App\Events\ReviewDeleted;
use App\Events\StoreUnpublished;
use App\Events\VerificationRequestApproved;
use App\Events\VerificationRequestCreated;
use App\Events\VerificationRequestRejected;
use App\Listeners\SendClientCancelledOrderNotification;
use App\Listeners\SendOrderAcceptedNotification;
use App\Listeners\SendOrderPlacedNotification;
use App\Listeners\SendOrderReadyNotification;
use App\Listeners\SendOrderRejectedNotification;
use App\Listeners\SendPaymentRequestAcceptedNotification;
use App\Listeners\SendPaymentRequestCreatedNotification;
use App\Listeners\SendPaymentRequestPaidNotification;
use App\Listeners\SendPaymentRequestRejectedNotification;
use App\Listeners\SendPickRequestConfirmedNotification;
use App\Listeners\SendPickRequestCreatedNotification;
use App\Listeners\SendPickRequestRejectedNotification;
use App\Listeners\SendReviewCreatedNotification;
use App\Listeners\SendReviewDeletedNotification;
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
        OrderPlaced::class => [
            SendOrderPlacedNotification::class,
        ],
        ClientCancelledOrder::class => [
            SendClientCancelledOrderNotification::class,
        ],
        OrderRejected::class => [
            SendOrderRejectedNotification::class,
        ],
        OrderAccepted::class => [
            SendOrderAcceptedNotification::class,
        ],
        OrderReady::class => [
            SendOrderReadyNotification::class,
        ],
        PickRequestCreated::class => [
            SendPickRequestCreatedNotification::class,
        ],
        PickRequestRejected::class => [
            SendPickRequestRejectedNotification::class,
        ],
        PickRequestConfirmed::class => [
            SendPickRequestConfirmedNotification::class,
        ],
        ReviewCreated::class => [
            SendReviewCreatedNotification::class,
        ],
        ReviewDeleted::class => [
            SendReviewDeletedNotification::class,
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
