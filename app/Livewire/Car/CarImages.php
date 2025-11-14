<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Livewire\Component;

class CarImages extends Component
{
    public $carId;
    public $car;

    public function mount($carId)
    {
        $this->carId = $carId;
    }

    public function render()
    {
        $this->car = Car::with(['images', 'maker', 'model'])->findOrFail($this->carId);
        return view('livewire.car.car-images', ['pollInterval' => rand(2, 10)]);
    }
}
