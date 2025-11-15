<?php

namespace App\Providers;

use App\Events\CarDataChanged;
use App\Listeners\ClearCarCache;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CarDataChanged::class => [
            ClearCarCache::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
