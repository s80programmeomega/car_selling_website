<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\Feature;

class FeatureObserver
{
    public function created(Feature $feature): void
    {
        // foreach ($feature->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }
    public function updated(Feature $feature): void
    {
        // dd('feature updated observer called');
    //     foreach ($feature->cars as $car) {
    //         $event = event(new CarDataChanged($car));
    //         // dd('feature updated observer called inside loop', $event);
    //     }
    }

    public function deleted(Feature $feature): void
    {
        // foreach ($feature->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }
}
