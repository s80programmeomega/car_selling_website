<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\FuelType;

class FuelTypeObserver
{
    public function created(FuelType $fuelType): void
    {
        // foreach ($fuelType->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }

    public function updated(FuelType $fuelType): void
    {
        // foreach ($fuelType->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }

    public function deleted(FuelType $fuelType): void
    {
        // foreach ($fuelType->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }
}
