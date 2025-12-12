<?php

namespace App\Observers;

use App\Events\CarCreated;
use App\Events\CarDataChanged;
use App\Events\CarDeleted;
use App\Events\FavoriteCarUpdated;
use App\Models\Car;
use App\Notifications\CarSold;
use App\Notifications\FavoriteCarPriceDropped;
use App\Notifications\FavoriteCarUpdated as NotificationsFavoriteCarUpdated;

class CarObserver
{
    public static array $car_data_before_delete = [];

    public function created(Car $car): void
    {
        event(new CarCreated($car));
    }

    public function updating(Car $car): void
    {
        // Check if price is changed
        if ($car->isDirty('price')) {
            $oldPrice = $car->getOriginal('price');
            $newPrice = $car->price;

            // Only notify if price dropped
            if ($newPrice < $oldPrice) {
                // Get all users who favorited this car
                $users = $car->favoritedBy;

                // Send notification to each user
                foreach ($users as $user) {
                    $user->notify(new FavoriteCarPriceDropped($car, $oldPrice, $newPrice));
                }
            }
        }
    }

    public function updated(Car $car): void
    {
        $changes = $car->getChanges();

        // exclude irrelevant fields
        $relevantChanges = array_diff_key($changes, array_flip(['updated_by', 'updated_at']));

        if (count($relevantChanges) === 1 && $car->wasChanged('view_count')) {
            return;
        }

        // Check if car status changed to sold
        if ($car->wasChanged('status') && $car->status === 'sold') {
            $car->owner->notify(new CarSold($car));

            // Notify users who favorited this car
            $users = $car->favoritedBy;
            foreach ($users as $user) {
                $user->notify(new NotificationsFavoriteCarUpdated($car, 'This car has been sold'));
            }
        }

        // Check if car became available again
        if ($car->wasChanged('published') && $car->published === true) {
            $users = $car->favoritedBy;
            foreach ($users as $user) {
                $user->notify(new NotificationsFavoriteCarUpdated($car, 'This car is now available'));
            }
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
