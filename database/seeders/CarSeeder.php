<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\State;
use App\Models\City;
use App\Models\Feature;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        // Create some users first
        $users = User::factory()->count(5)->create();

        // Create 20 sample cars
        for ($i = 0; $i < 20; $i++) {
            $maker = Maker::inRandomOrder()->first();
            $model = CarModel::where('maker_id', $maker->id)->inRandomOrder()->first();

            if (!$model) {
                continue;
            }

            $state = State::inRandomOrder()->first();
            $city = City::where('state_id', $state->id)->inRandomOrder()->first();

            $car = Car::create([
                'owner_id' => $users->random()->id,
                'maker_id' => $maker->id,
                'model_id' => $model->id,
                'car_type_id' => CarType::inRandomOrder()->first()->id,
                'fuel_type_id' => FuelType::inRandomOrder()->first()->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'year' => rand(2015, 2024),
                'price' => rand(15000, 75000),
                'mileage' => rand(5000, 100000),
                'transmission' => ['Automatic', 'Manual', 'CVT'][rand(0, 2)],
                'color' => ['Black', 'White', 'Silver', 'Blue', 'Red'][rand(0, 4)],
                'doors' => [2, 4, 5][rand(0, 2)],
                'seats' => [2, 5, 7][rand(0, 2)],
                'engine_size' => ['1.5L', '2.0L', '2.5L', '3.0L', '3.5L'][rand(0, 4)],
                'condition' => ['new', 'used', 'certified'][rand(0, 2)],
                'description' => 'Great car in excellent condition. Well maintained.',
                'published' => true,
                'featured' => rand(0, 1) == 1,
                'status' => 'available',
            ]);

            // Attach random features
            $features = Feature::inRandomOrder()->take(rand(3, 7))->pluck('id');
            $car->features()->attach($features);
        }
    }
}
