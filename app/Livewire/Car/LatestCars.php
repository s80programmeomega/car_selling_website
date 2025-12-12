<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Component to display latest published cars with pagination.
 *
 * Implements Redis caching with tags for efficient cache management.
 */
class LatestCars extends Component
{
    use WithPagination;

    /**
     * Render the component with cached car data.
     *
     * Cache Strategy:
     * - Tagged with 'cars' for easy invalidation
     * - Separate cache key per page for pagination
     * - 1 hour TTL (3600 seconds)
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $page = $this->getPage();
        $cacheKey = "latest-cars-page-{$page}";

        // Use cache tags for organized invalidation
        $latest_cars = Cache::tags(['cars'])->remember($cacheKey, 3600, function () {
            return Car::published()
                ->with(['maker', 'model', 'carType', 'fuelType', 'city', 'images'])
                ->latest()
                ->paginate(10, ['*'], 'page', $this->getPage());
        });

        return view('livewire.car.latest-cars', compact('latest_cars'));
    }
}
