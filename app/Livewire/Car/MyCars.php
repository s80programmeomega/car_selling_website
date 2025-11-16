<?php

namespace App\Livewire\Car;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyCars extends Component
{
    use WithPagination;

    public function delete($carId)
    {
        $car = Auth::user()->cars()->findOrFail($carId);
        $car->delete();

        session()->flash('message', 'Car deleted successfully.');
    }

    public function render()
    {
        $cars = Auth::user()
            ->cars()
            ->with(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city'])
            ->latest()
            ->paginate(2);

        return view('livewire.car.my-cars', compact('cars'));
    }
}
