<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;

class CarImageSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();

        foreach ($cars as $car) {
            // Create 3-5 images per car
            for ($i = 0; $i < rand(3, 5); $i++) {
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => 'cars/placeholder-' . rand(1, 10) . '.jpg',
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
