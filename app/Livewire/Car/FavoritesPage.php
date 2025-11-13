<?php

namespace App\Livewire\Car;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FavoritesPage extends Component
{
    use WithPagination;

    protected $listeners = ['favoriteToggled' => 'handleFavoriteToggled'];

    public function handleFavoriteToggled($carId, $isFavorited)
    {
        if (!$isFavorited) {
            $this->dispatch('$refresh');
        }
    }

    public function render()
    {
        $favorites = Auth::user()
            ->favorites()
            ->with(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city'])
            ->paginate(2);

        return view('livewire.car.favorites-page', compact('favorites'));
    }
}
