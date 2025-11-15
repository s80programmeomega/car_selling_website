<?php

namespace App\Listeners;

use App\Events\CarDataChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class ClearCarCache
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
    public function handle(CarDataChanged $event): void
    {
        // Clear latest cars pagination cache
        $perPage = 9;  // Same as in LatestCars component
        $totalCars = \App\Models\Car::published()->count();
        $totalPages = ceil($totalCars / $perPage);

        for ($page = 1; $page <= $totalPages; $page++) {
            Cache::forget("latest-cars-page-{$page}");
        }

        // Clear all search cache (use cache tags if using Redis, otherwise flush pattern)
        // Since search uses MD5 hashes, we need to clear all search-* keys
        Cache::flush();  // Or use tags if Redis is configured
    }
}
