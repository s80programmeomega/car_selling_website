<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\CarInquiry;

class CarInquiryObserver
{
    public function created(CarInquiry $carInquiry): void
    {
        if ($carInquiry->car) {
            event(new CarDataChanged($carInquiry->car));
        }
    }

    public function updated(CarInquiry $carInquiry): void
    {
        if ($carInquiry->car) {
            event(new CarDataChanged($carInquiry->car));
        }
    }

    public function deleted(CarInquiry $carInquiry): void
    {
        if ($carInquiry->car) {
            event(new CarDataChanged($carInquiry->car));
        }
    }
}
