<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class LatestCars extends Component
{
    use WithPagination;

    public function render()
    {
        // Get current page number
        $page = $this->getPage();

        // Create unique cache key for this page
        $cacheKey = "latest-cars-page-{$page}";

        // Cache for 3600 seconds
        $latest_cars = Cache::remember($cacheKey, 3600, function () {
            return Car::published()
                ->with(['maker', 'model', 'carType', 'fuelType', 'city', 'images'])
                ->latest()
                ->paginate(9);
        });

        return view('livewire.car.latest-cars', compact('latest_cars'));
    }
}
