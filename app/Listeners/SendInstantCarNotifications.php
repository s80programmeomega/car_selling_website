<?php

namespace App\Listeners;

use App\Jobs\SendNewCarNotifications;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInstantCarNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        /// Only dispatch for instant subscriptions
        dispatch(new SendNewCarNotifications(
            Subscription::FREQUENCY_INSTANT,
            $event->car->id
        ));
    }
}
