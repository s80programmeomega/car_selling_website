<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\CarImage;

class CarImageObserver
{
    public function created(CarImage $carImage): void
    {
        if ($carImage->car) {
            event(new CarDataChanged($carImage->car));
        }
    }

    public function updated(CarImage $carImage): void
    {
        if ($carImage->car) {
            event(new CarDataChanged($carImage->car));
        }
    }

    public function deleted(CarImage $carImage): void
    {
        if ($carImage->car) {
            event(new CarDataChanged($carImage->car));
        }
    }
}
