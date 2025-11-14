<?php

namespace App\Livewire\Car;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class HomeSearchForm extends Component
{
    public $maker_id = '';
    public $model_id = '';
    public $state_id = '';
    public $city_id = '';
    public $car_type_id = '';
    public $year_from = '';
    public $year_to = '';
    public $price_from = '';
    public $price_to = '';
    public $fuel_type_id = '';

    public function updatedMakerId()
    {
        $this->model_id = ''; // Reset model when maker changes
    }

    public function updatedStateId()
    {
        $this->city_id = ''; // Reset city when state changes
    }

    public function resetForm()
    {
        $this->reset([
            'maker_id', 'model_id', 'state_id', 'city_id', 'car_type_id',
            'year_from', 'year_to', 'price_from', 'price_to', 'fuel_type_id'
        ]);
    }

    public function search()
    {
        $params = array_filter([
            'maker_id' => $this->maker_id,
            'model_id' => $this->model_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'car_type_id' => $this->car_type_id,
            'year_from' => $this->year_from,
            'year_to' => $this->year_to,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'fuel_type_id' => $this->fuel_type_id,
        ]);

        return redirect()->route('car.search', $params);
    }

    public function render()
    {
        // Get dynamic models based on selected maker
        $models = $this->maker_id
            ? CarModel::where('maker_id', $this->maker_id)->orderBy('name')->get()
            : collect();

        // Get dynamic cities based on selected state
        $cities = $this->state_id
            ? City::where('state_id', $this->state_id)->orderBy('name')->get()
            : collect();

            return view('livewire.car.home-search-form', [
                'makers' => Cache::remember('makers', 3600, fn() => Maker::orderBy('name')->get()),
                'carTypes' => Cache::remember('car-types', 3600, fn() => CarType::orderBy('name')->get()),
                'fuelTypes' => Cache::remember('fuel-types', 3600, fn() => FuelType::orderBy('name')->get()),
                'states' => Cache::remember('states', 3600, fn() => State::orderBy('name')->get()),
                'models' => $models,
                'cities' => $cities,
            ]);
    }
}
