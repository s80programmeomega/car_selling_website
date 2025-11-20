<?php

namespace App\Listeners;

use App\Events\CarCreated;
use App\Events\CarDataChanged;
use Illuminate\Support\Facades\Cache;

/**
 * Listener to clear car-related cache when car data changes.
 *
 * Uses Redis cache tags for efficient, granular cache invalidation
 * instead of flushing the entire cache.
 */
class ClearCarCache
{
    /**
     * Handle the event.
     *
     * Clears only car-related cache entries using tags:
     * - 'cars': All car listing caches
     * - 'dropdowns': Dropdown data (makers, models, etc.)
     *
     * @param CarDataChanged $event
     * @return void
     */
    public function handle($event): void
    {
        // Clear all car-related caches using tags
        // This only affects caches tagged with 'cars', not the entire cache
        Cache::tags(['cars'])->flush();

        // Also clear dropdown caches as they may include counts or related data
        Cache::tags(['dropdowns'])->flush();
    }
}
