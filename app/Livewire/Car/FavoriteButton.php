<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Livewire\Component;
use App\Events\FavoriteCarUpdated;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            $this->isFavorited = Auth::user()->favorites()->where('car_id', $this->car->id)->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isFavorited) {
            Auth::user()->favorites()->detach($this->car->id);
            $this->isFavorited = false;
        } else {
            Auth::user()->favorites()->attach($this->car->id);
            $this->isFavorited = true;
        }

        // Emit event to parent component
        // dd('Before toggling favorite count');
        event(new FavoriteCarUpdated($this->car, Auth::id()));
    }

    public function render()
    {
        return view('livewire.car.favorite-button');
    }
}
