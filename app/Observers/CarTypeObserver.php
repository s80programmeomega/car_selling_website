<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\CarType;

class CarTypeObserver
{
    public function created(CarType $carType): void
    {
    //     foreach ($carType->cars as $car) {
    //         event(new CarDataChanged($car));
    //     }
    }
    public function updated(CarType $carType): void
    {
        // foreach ($carType->cars as $car) {
        //     event(new CarDataChanged($car));
        // }
    }

    public function deleted(CarType $carType): void
    {
    //     foreach ($carType->cars as $car) {
    //         event(new CarDataChanged($car));
    //     }
    }
}
