<?php

namespace App\Observers;

use App\Events\CarCreated;
use App\Events\CarDataChanged;
use App\Events\CarDeleted;
use App\Models\Car;

class CarObserver
{

    public static array $car_data_before_delete = [];

    public function created(Car $car): void
    {
        event(new CarCreated($car));
    }

    public function updated(Car $car): void
    {
        // dd('Observer triggered', $car->getChanges());
        $changes = $car->getChanges();

        // exclude irrelevant fields
        $relevantChanges = array_diff_key($changes, array_flip(['updated_by', 'updated_at']));

        if (count($relevantChanges) === 1 && $car->wasChanged('view_count')) {
            return;
        }

        // dd($changes, 'before firing event');
        event(new CarDataChanged($car));
        // dd($changes, 'after firing event');
    }

    public function deleting(Car $car): void
    {
        event(new CarDeleted([
            'id' => $car->id,
            'maker' => $car->maker->name,
            'model' => $car->model->name,
            'year' => $car->year,
            'price' => $car->price,
        ]));
    }

    // public function deleting(Car $car): void
    // {
    //     $this->car_data_before_delete = $car->toArray();
    //     // dd('CarObserver deleting', $this->car_data_before_delete);
    //     event(new CarDeleted($this->car_data_before_delete));
    //     // dd('Car data set on deleting', $this->car_data_before_delete);
    // }

    // public function deleted(): void
    // {
    //     dd('CarObserver deleted', $this->car_data_before_delete);
    //     event(new CarDeleted($this->car_data_before_delete));
    // }
}
