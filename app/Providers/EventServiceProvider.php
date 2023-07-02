<?php

namespace App\Providers;

use App\Events\StoreUnpublished;
use App\Events\VerificationRequestApproved;
use App\Events\VerificationRequestCreated;
use App\Events\VerificationRequestRejected;
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
