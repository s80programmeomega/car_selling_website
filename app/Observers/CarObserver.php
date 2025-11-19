<?php

namespace App\Observers;

use App\Events\CarCreated;
use App\Events\CarDataChanged;
use App\Models\Car;

class CarObserver
{
    public function created(Car $car): void
    {
        event(new CarCreated($car));
    }

    public function updated(Car $car): void
    {
        // dd('Observer triggered', $car->getChanges());
        $changes = $car->getChanges();

        // exclude irrelevant fields
        $relevantChanges = array_diff_key($changes, array_flip(['updated_by', 'updated_at']));

        if (count($relevantChanges) === 1 && $car->wasChanged('view_count')) {
            return;
        }

        // dd($changes, 'before firing event');
        event(new CarDataChanged($car));
        // dd($changes, 'after firing event');
    }


    public function deleted(Car $car): void
    {
        event(new CarDataChanged($car));
    }
}
