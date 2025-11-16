<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ReviewsList extends Component
{
    use WithPagination;

    public Car $car;

    public function mount(Car $car)
    {
        $this->car = $car;
    }

    #[On('reviewAdded')]
    public function refreshReviews()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.car.reviews-list', [
            'reviews' => $this->car->reviews()
                ->with('reviewer')
                ->latest()
                ->paginate(10),
            'averageRating' => $this->car->reviews()->avg('rating'),
            'totalReviews' => $this->car->reviews()->count(),
        ]);
    }
}
