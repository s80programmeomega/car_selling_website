<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\Feature;
use Livewire\Component;

class CarDetails extends Component
{
    public $carId;
    public $car;
    public $allFeatures;
    public $carFeatureIds;

    public function mount($carId)
    {
        $this->carId = $carId;
        $this->loadCarData();
    }

    public function loadCarData()
    {
        $this->car = Car::with(['maker', 'model', 'carType', 'fuelType', 'state', 'city', 'owner.cars'])
            ->findOrFail($this->carId);

        $this->allFeatures = Feature::all();
        $this->carFeatureIds = $this->car->features->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.car.car-details');
    }
}
