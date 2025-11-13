<?php
namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OldSearchCars extends Component
{
    use WithPagination;

    // Search query - synced with URL
    #[Url(as: 'q')]
    public $search = '';

    // Filters - synced with URL
    #[Url]
    public $maker_id = '';

    #[Url]
    public $car_type_id = '';

    #[Url]
    public $fuel_type_id = '';

    #[Url]
    public $state_id = '';

    #[Url]
    public $year_from = '';

    #[Url]
    public $year_to = '';

    #[Url]
    public $price_from = '';

    #[Url]
    public $price_to = '';

    #[Url]
    public $sort_by = 'year';

    /**
     * Reset pagination when search/filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMakerId()
    {
        $this->resetPage();
    }

    public function updatingCarTypeId()
    {
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->reset([
            'search',
            'maker_id',
            'car_type_id',
            'fuel_type_id',
            'state_id',
            'year_from',
            'year_to',
            'price_from',
            'price_to',
        ]);
    }

    public function render()
    {
        // Start with search query
        $query = Car::search($this->search);

        // Apply filters using Typesense's filter syntax
        $filters = [];

        if ($this->maker_id) {
            $maker = Maker::find($this->maker_id);
            if ($maker) {
                $filters[] = "maker:={$maker->name}";
            }
        }

        if ($this->car_type_id) {
            $carType = CarType::find($this->car_type_id);
            if ($carType) {
                $filters[] = "car_type:={$carType->name}";
            }
        }

        if ($this->fuel_type_id) {
            $fuelType = FuelType::find($this->fuel_type_id);
            if ($fuelType) {
                $filters[] = "fuel_type:={$fuelType->name}";
            }
        }

        if ($this->state_id) {
            $state = State::find($this->state_id);
            if ($state) {
                $filters[] = "state:={$state->name}";
            }
        }

        if ($this->year_from) {
            $filters[] = "year:>={$this->year_from}";
        }

        if ($this->year_to) {
            $filters[] = "year:<={$this->year_to}";
        }

        if ($this->price_from) {
            $filters[] = "price:>={$this->price_from}";
        }

        if ($this->price_to) {
            $filters[] = "price:<={$this->price_to}";
        }

        // Always filter for published cars
        $filters[] = 'published:=true';

        // Apply all filters
        // if (!empty($filters)) {
        //     $query->filter(implode(' && ', $filters));
        // }
        // Apply all filters
        if (!empty($filters)) {
            $query->options([
                'filter_by' => implode(' && ', $filters)
            ]);
        }

        // Apply sorting
        $query->orderBy($this->sort_by, 'desc');

        // Get results with pagination
        $cars = $query->paginate(12);

        // Load relationships for display
        // $cars->load(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city']);

        return view('livewire.car.old-search-cars', [
            'cars' => $cars,
            'makers' => Maker::orderBy('name')->get(),
            'carTypes' => CarType::orderBy('name')->get(),
            'fuelTypes' => FuelType::orderBy('name')->get(),
            'states' => State::orderBy('name')->get(),
        ]);
    }
}
