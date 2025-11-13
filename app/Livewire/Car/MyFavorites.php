<?php

namespace App\Livewire\Car;

use Livewire\Component;
use Livewire\WithPagination;

class MyFavorites extends Component
{
    use WithPagination;

    public function render()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city'])
            ->paginate(12);

        return view('livewire.car.my-favorites', compact('favorites'));
    }
}
