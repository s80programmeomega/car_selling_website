<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $fuelTypes = [
            ['name' => 'Gasoline', 'description' => 'Regular unleaded gasoline'],
            ['name' => 'Diesel', 'description' => 'Diesel fuel'],
            ['name' => 'Electric', 'description' => 'Battery electric vehicle'],
            ['name' => 'Hybrid', 'description' => 'Gasoline-electric hybrid'],
            ['name' => 'Plug-in Hybrid', 'description' => 'Rechargeable hybrid'],
        ];

        foreach ($fuelTypes as $fuelType) {
            FuelType::create($fuelType);
        }
    }
}
