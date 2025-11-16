<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\Review;

class ReviewObserver
{
    public function created(Review $review): void
    {
        if ($review->car) {
            event(new CarDataChanged($review->car));
        }
    }

    public function updated(Review $review): void
    {
        if ($review->car) {
            event(new CarDataChanged($review->car));
        }
    }

    public function deleted(Review $review): void
    {
        if ($review->car) {
            event(new CarDataChanged($review->car));
        }
    }
}
