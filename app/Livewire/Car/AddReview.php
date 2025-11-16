<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddReview extends Component
{
    public Car $car;
    public $rating = 5;
    public $comment;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount(Car $car)
    {
        $this->car = $car;
    }

    public function submit()
    {
        $this->validate();

        Review::updateOrCreate(
            [
                'reviewer_id' => Auth::id(),
                'seller_id' => $this->car->owner_id,
                'car_id' => $this->car->id,
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]
        );

        session()->flash('message', 'Review submitted successfully.');
        return redirect()->route('car.show', $this->car);
    }

    public function render()
    {
        return view('livewire.car.add-review');
    }
}
