<?php

namespace App\Observers;

use App\Events\CarDataChanged;
use App\Models\Review;
use App\Notifications\ReviewReceived;

class ReviewObserver
{
    public function created(Review $review): void
    {
        if ($review->car) {
            event(new CarDataChanged($review->car));
        }
        // Notify seller about new review
        if ($review->seller) {
            $review->seller->notify(new ReviewReceived($review));
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
