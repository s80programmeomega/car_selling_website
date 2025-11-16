<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\State;
use Illuminate\Support\Facades\Cache;

class StateObserver
{
    /**
     * Handle the State "created" event.
     */
    public function created(State $state): void
    {
        // foreach ($state->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-states');
    }

    /**
     * Handle the State "updated" event.
    */
    public function updated(State $state): void
    {
        // foreach ($state->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-states');
    }

    /**
     * Handle the State "deleted" event.
    */
    public function deleted(State $state): void
    {
        // foreach ($state->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
        Cache::forget('dropdown-states');
    }

    /**
     * Handle the State "restored" event.
     */
    public function restored(State $state): void
    {
        //
    }

    /**
     * Handle the State "force deleted" event.
     */
    public function forceDeleted(State $state): void
    {
        //
    }
}
