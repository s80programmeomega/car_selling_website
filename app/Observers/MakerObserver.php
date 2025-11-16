<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\Maker;
use Illuminate\Support\Facades\Cache;

class MakerObserver
{
    /**
     * Handle the Maker "created" event.
     */
    public function created(Maker $maker): void
    {
        // foreach ($maker->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "updated" event.
     */
    public function updated(Maker $maker): void
    {
        // foreach ($maker->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "deleted" event.
     */
    public function deleted(Maker $maker): void
    {
        // foreach ($maker->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "restored" event.
     */
    public function restored(Maker $maker): void
    {
        //
    }

    /**
     * Handle the Maker "force deleted" event.
     */
    public function forceDeleted(Maker $maker): void
    {
        //
    }
}
