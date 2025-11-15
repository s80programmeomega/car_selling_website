<?php

namespace App\Observers;

use App\Models\CarModel;
use Illuminate\Support\Facades\Cache;

class CarModelObserver
{
    /**
     * Handle the CarModel "created" event.
     */
    public function created(CarModel $carModel): void
    {
        Cache::forget("models-maker-{$carModel->maker_id}");
    }

    /**
     * Handle the CarModel "updated" event.
    */
    public function updated(CarModel $carModel): void
    {
        Cache::forget("models-maker-{$carModel->maker_id}");
    }

    /**
     * Handle the CarModel "deleted" event.
    */
    public function deleted(CarModel $carModel): void
    {
        Cache::forget("models-maker-{$carModel->maker_id}");
    }

    /**
     * Handle the CarModel "restored" event.
     */
    public function restored(CarModel $carModel): void
    {
        //
    }

    /**
     * Handle the CarModel "force deleted" event.
     */
    public function forceDeleted(CarModel $carModel): void
    {
        //
    }
}
