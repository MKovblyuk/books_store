<?php

namespace App\Providers;

use App\Events\Books\BookDeleted;
use App\Events\Books\FragmentDeleted;
use App\Events\Orders\OrderCreated;
use App\Events\Orders\OrderUpdated;
use App\Listeners\Books\DeleteBookCoverImage;
use App\Listeners\Books\DeleteFragmentFromStorage;
use App\Listeners\SendNotification;
use App\Models\V1\Orders\Order;
use App\Observers\OrderObserver;
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
        FragmentDeleted::class => [
            DeleteFragmentFromStorage::class,
        ],
        BookDeleted::class => [
            DeleteBookCoverImage::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
