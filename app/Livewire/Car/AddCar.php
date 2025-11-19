<?php

namespace App\Livewire\Car;

use App\Events\CarCreated;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCar extends Component
{
    use WithFileUploads;

    public $maker_id,
        $model_id,
        $year,
        $car_type_id,
        $price,
        $vin_code,
        $mileage;

    public $fuel_type_id,
        $state_id,
        $city_id,
        $address,
        $phone,
        $transmission;

    public $description,
        $published = false,
        $featured = false;

    public $color,
        $interior_color,
        $doors,
        $seats,
        $engine_size;

    public $condition = 'used',
        $accident_history = false,
        $number_of_owners;

    public $status = 'available';
    public $features = [];
    public $images = [];

    public $makers,
        $models = [],
        $carTypes,
        $fuelTypes,
        $states,
        $cities = [],
        $allFeatures;

    public function mount()
    {
        $this->makers = Maker::all();
        $this->carTypes = CarType::all();
        $this->fuelTypes = FuelType::all();
        $this->states = State::all();
        $this->allFeatures = Feature::all();
    }

    public function updatedMakerId($value)
    {
        $this->models = CarModel::where('maker_id', $value)->get();
        $this->model_id = null;
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->get();
        $this->city_id = null;
    }

    public function resetForm()
    {
        $this->reset([
            'maker_id', 'model_id', 'year', 'car_type_id', 'price', 'vin_code', 'mileage',
            'fuel_type_id', 'state_id', 'city_id', 'address', 'phone', 'transmission',
            'description', 'published', 'featured', 'color', 'interior_color', 'doors',
            'seats', 'engine_size', 'condition', 'accident_history', 'number_of_owners',
            'status', 'features', 'images'
        ]);
        $this->models = [];
        $this->cities = [];
    }

    public function save()
    {
        $this->validate([
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:car_models,id',
            'car_type_id' => 'required|exists:car_types,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'transmission' => 'required|string',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
            'vin_code' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'condition' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $car = Car::create([
                'owner_id' => Auth::id(),
                'maker_id' => $this->maker_id,
                'model_id' => $this->model_id,
                'car_type_id' => $this->car_type_id,
                'fuel_type_id' => $this->fuel_type_id,
                'transmission' => $this->transmission,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'year' => $this->year,
                'price' => $this->price,
                'mileage' => $this->mileage,
                'vin_code' => $this->vin_code,
                'address' => $this->address,
                'phone' => $this->phone,
                'description' => $this->description,
                'published' => $this->published,
                'featured' => $this->featured,
                'color' => $this->color,
                'interior_color' => $this->interior_color,
                'doors' => $this->doors,
                'seats' => $this->seats,
                'engine_size' => $this->engine_size,
                'condition' => $this->condition,
                'accident_history' => $this->accident_history,
                'number_of_owners' => $this->number_of_owners,
                'status' => $this->status,
            ]);

            if (!empty($this->features)) {
                $car->features()->attach($this->features);
            }

            if (!empty($this->images)) {
                foreach ($this->images as $index => $image) {
                    $path = $image->store('cars', 'public');
                    $car->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            Broadcast(new CarCreated($car));

            session()->flash('message', 'Car added successfully.');
            return redirect()->route('car.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create car: ' . $e->getMessage());
            session()->flash('error', 'Failed to add car. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.car.add-car');
    }
}
