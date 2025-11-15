<?php

namespace App\Observers;

use App\Models\Maker;
use Illuminate\Support\Facades\Cache;

class MakerObserver
{
    /**
     * Handle the Maker "created" event.
     */
    public function created(Maker $maker): void
    {
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "updated" event.
     */
    public function updated(Maker $maker): void
    {
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "deleted" event.
     */
    public function deleted(Maker $maker): void
    {
        Cache::forget('dropdown-makers');
    }

    /**
     * Handle the Maker "restored" event.
     */
    public function restored(Maker $maker): void
    {
        //
    }

    /**
     * Handle the Maker "force deleted" event.
     */
    public function forceDeleted(Maker $maker): void
    {
        //
    }
}
