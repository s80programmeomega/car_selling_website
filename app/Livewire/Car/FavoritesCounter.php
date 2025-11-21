<?php

namespace App\Livewire\Car;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class FavoritesCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('favoriteToggled')]
    public function updateCount()
    {
        if (Auth::check()) {
            $this->count = Auth::user()->favorites()->count();
        }
    }

    public function render()
    {
        return view('livewire.car.favorites-counter');
    }
}
