<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SearchCars extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url]
    public $maker_id = '';

    #[Url]
    public $model_id = '';

    #[Url]
    public $car_type_id = '';

    #[Url]
    public $fuel_type_id = '';

    #[Url]
    public $state_id = '';

    #[Url]
    public $city_id = '';

    #[Url]
    public $year_from = '';

    #[Url]
    public $year_to = '';

    #[Url]
    public $price_from = '';

    #[Url]
    public $price_to = '';

    #[Url]
    public $mileage = '';

    #[Url]
    public $sort_by = 'year';

    public function mount()
    {
        // Initialize from URL parameters
        $this->maker_id = request('maker_id', '');
        $this->model_id = request('model_id', '');
        $this->state_id = request('state_id', '');
        $this->city_id = request('city_id', '');
        $this->car_type_id = request('car_type_id', '');
        $this->year_from = request('year_from', '');
        $this->year_to = request('year_to', '');
        $this->price_from = request('price_from', '');
        $this->price_to = request('price_to', '');
        $this->fuel_type_id = request('fuel_type_id', '');
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMakerId()
    {
        $this->model_id = '';  // Reset model when maker changes
        $this->resetPage();
    }

    public function updatingStateId()
    {
        $this->city_id = '';  // Reset city when state changes
        $this->resetPage();
    }

    public function updatingCarTypeId()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'maker_id',
            'model_id',
            'car_type_id',
            'fuel_type_id',
            'state_id',
            'city_id',
            'year_from',
            'year_to',
            'price_from',
            'price_to',
            'mileage',
        ]);
        $this->resetPage();
    }

    public function render()
    {
        // Create unique cache key from all filters
        $cacheKey = 'search-' . md5(json_encode([
            'search' => $this->search,
            'maker_id' => $this->maker_id,
            'model_id' => $this->model_id,
            'car_type_id' => $this->car_type_id,
            'fuel_type_id' => $this->fuel_type_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'year_from' => $this->year_from,
            'year_to' => $this->year_to,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'mileage' => $this->mileage,
            'sort_by' => $this->sort_by,
            'page' => $this->getPage(),
        ]));

        // Cache search results for 2 minutes
        $cars = Cache::remember($cacheKey, 120, function() {
            $query = Car::search($this->search);
            $filters = [];

            // Apply filters
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

            if ($this->mileage) {
                $filters[] = "mileage:<={$this->mileage}";
            }

            $filters[] = 'published:=true';

            if (!empty($filters)) {
                $query->options([
                    'filter_by' => implode(' && ', $filters)
                ]);
            }

            $query->orderBy($this->sort_by, 'desc');

            return $query->paginate(5);
        });

        // Get dynamic models based on selected maker
        $models = $this->maker_id
            ? CarModel::where('maker_id', $this->maker_id)->orderBy('name')->get()
            : collect();

        // Get dynamic cities based on selected state
        $cities = $this->state_id
            ? City::where('state_id', $this->state_id)->orderBy('name')->get()
            : collect();

        return view('livewire.car.search-cars', [
            'cars' => $cars,
            'makers' => Cache::remember('dropdown-makers', 3600, fn() => Maker::orderBy('name')->get()),
            'models' => $models,
            'carTypes' => Cache::remember('dropdown-car-types', 3600, fn() => CarType::orderBy('name')->get()),
            'fuelTypes' => Cache::remember('dropdown-fuel-types', 3600, fn() => FuelType::orderBy('name')->get()),
            'states' => Cache::remember('dropdown-states', 3600, fn() => State::orderBy('name')->get()),
            'cities' => $cities,
        ]);
    }

}

