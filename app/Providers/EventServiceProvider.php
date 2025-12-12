<?php

namespace App\Providers;

use App\Events\CarCreated;
use App\Events\CarDataChanged;
use App\Events\CarDeleted;
use App\Listeners\ClearCarCache;
use App\Listeners\SendInstantCarNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CarCreated::class => [
            ClearCarCache::class,
            SendInstantCarNotifications::class,
        ],
        CarDataChanged::class => [
            ClearCarCache::class,
        ],
        CarDeleted::class => [
            ClearCarCache::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
