<?php

namespace App\Livewire\Car;

use App\Models\Car;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\State;
use App\Models\City;
use App\Models\Feature;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditCar extends Component
{
    use WithFileUploads;

    public Car $car;

    public $maker_id, $model_id, $year, $car_type_id, $price, $vin_code, $mileage;
    public $fuel_type_id, $state_id, $city_id, $address, $phone, $transmission;
    public $description, $published = false, $featured = false;
    public $color, $interior_color, $doors, $seats, $engine_size;
    public $condition = 'used', $accident_history = false, $number_of_owners;
    public $status = 'available';
    public $features = [];
    public $images = [];

    public $makers, $models = [], $carTypes, $fuelTypes, $states, $cities = [], $allFeatures;

    public function mount(Car $car)
    {
        $this->car = $car;

        // Populate form with existing data
        $this->maker_id = $car->maker_id;
        $this->model_id = $car->model_id;
        $this->year = $car->year;
        $this->car_type_id = $car->car_type_id;
        $this->price = $car->price;
        $this->vin_code = $car->vin_code;
        $this->mileage = $car->mileage;
        $this->fuel_type_id = $car->fuel_type_id;
        $this->state_id = $car->state_id;
        $this->city_id = $car->city_id;
        $this->address = $car->address;
        $this->phone = $car->phone;
        $this->transmission = $car->transmission;
        $this->description = $car->description;
        $this->published = $car->published;
        $this->featured = $car->featured;
        $this->color = $car->color;
        $this->interior_color = $car->interior_color;
        $this->doors = $car->doors;
        $this->seats = $car->seats;
        $this->engine_size = $car->engine_size;
        $this->condition = $car->condition;
        $this->accident_history = $car->accident_history;
        $this->number_of_owners = $car->number_of_owners;
        $this->status = $car->status;
        $this->features = $car->features->pluck('id')->toArray();

        // Load dropdown data
        $this->makers = Maker::all();
        $this->models = CarModel::where('maker_id', $this->maker_id)->get();
        $this->carTypes = CarType::all();
        $this->fuelTypes = FuelType::all();
        $this->states = State::all();
        $this->cities = City::where('state_id', $this->state_id)->get();
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
        // Restore original car data
        $this->maker_id = $this->car->maker_id;
        $this->model_id = $this->car->model_id;
        $this->year = $this->car->year;
        $this->car_type_id = $this->car->car_type_id;
        $this->price = $this->car->price;
        $this->vin_code = $this->car->vin_code;
        $this->mileage = $this->car->mileage;
        $this->fuel_type_id = $this->car->fuel_type_id;
        $this->state_id = $this->car->state_id;
        $this->city_id = $this->car->city_id;
        $this->address = $this->car->address;
        $this->phone = $this->car->phone;
        $this->transmission = $this->car->transmission;
        $this->description = $this->car->description;
        $this->published = $this->car->published;
        $this->featured = $this->car->featured;
        $this->color = $this->car->color;
        $this->interior_color = $this->car->interior_color;
        $this->doors = $this->car->doors;
        $this->seats = $this->car->seats;
        $this->engine_size = $this->car->engine_size;
        $this->condition = $this->car->condition;
        $this->accident_history = $this->car->accident_history;
        $this->number_of_owners = $this->car->number_of_owners;
        $this->status = $this->car->status;
        $this->features = $this->car->features->pluck('id')->toArray();
        $this->images = [];

        // Reload dependent dropdowns
        $this->models = CarModel::where('maker_id', $this->maker_id)->get();
        $this->cities = City::where('state_id', $this->state_id)->get();
    }


    public function update()
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

            $this->car->update([
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

            $this->car->features()->sync($this->features);

            if (!empty($this->images)) {
                $existingCount = $this->car->images()->count();
                foreach ($this->images as $index => $image) {
                    $path = $image->store('cars', 'public');
                    $this->car->images()->create([
                        'image_path' => $path,
                        'is_primary' => $existingCount === 0 && $index === 0,
                        'sort_order' => $existingCount + $index,
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', 'Car updated successfully.');
            return redirect()->route('car.show', $this->car);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update car: ' . $e->getMessage());
            session()->flash('error', 'Failed to update car. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.car.edit-car');
    }
}
