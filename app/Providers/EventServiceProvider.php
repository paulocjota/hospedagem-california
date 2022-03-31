<?php

namespace App\Providers;

use App\Events\EntryCreated;
use App\Events\EntryFinished;
use App\Events\OrderRowCreated;
use App\Events\OrderRowDeleted;
use App\Listeners\AddProductQuantityToStock;
use App\Listeners\OccupyRoom;
use App\Listeners\ReleaseRoom;
use App\Listeners\RemoveProductQuantityFromStock;
use App\Models\Entry;
use App\Models\OrderRow;
use App\Models\Product;
use App\Observers\EntryObserver;
use App\Observers\OrderRowObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Entry::class => [EntryObserver::class],
        OrderRow::class => [OrderRowObserver::class],
        Product::class => [ProductObserver::class],
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderRowCreated::class => [
            RemoveProductQuantityFromStock::class,
        ],
        OrderRowDeleted::class => [
            AddProductQuantityToStock::class,
        ],
        EntryCreated::class => [
            OccupyRoom::class,
        ],
        EntryFinished::class => [
            ReleaseRoom::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
