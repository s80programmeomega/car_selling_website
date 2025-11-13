<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Livewire\Component;

class FavoriteButton extends Component
{
    public Car $car;
    public $isFavorited = false;

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->checkFavoriteStatus();
    }

    public function checkFavoriteStatus()
    {
        if (auth()->check()) {
            $this->isFavorited = auth()->user()->favorites()->where('car_id', $this->car->id)->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->isFavorited) {
            auth()->user()->favorites()->detach($this->car->id);
            $this->isFavorited = false;
        } else {
            auth()->user()->favorites()->attach($this->car->id);
            $this->isFavorited = true;
        }

        // Emit event to parent component
        $this->dispatch('favoriteToggled', $this->car->id, $this->isFavorited);
    }

    public function render()
    {
        return view('livewire.car.favorite-button');
    }
}
