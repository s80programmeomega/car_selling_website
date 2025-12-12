<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\CarInquiry;
use App\Notifications\CarInquiryReceived;

class CarInquiryObserver
{
    public function created(CarInquiry $carInquiry): void
    {
        if ($carInquiry->car) {
            event(new CarDataChanged($carInquiry->car));
            // Notify car owner about new inquiry
            $carInquiry->car->owner->notify(new CarInquiryReceived($carInquiry, $carInquiry->car));
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
