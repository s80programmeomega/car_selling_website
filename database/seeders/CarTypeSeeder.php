<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Sedan', 'description' => 'Four-door passenger car'],
            ['name' => 'SUV', 'description' => 'Sport Utility Vehicle'],
            ['name' => 'Truck', 'description' => 'Pickup truck'],
            ['name' => 'Coupe', 'description' => 'Two-door sports car'],
            ['name' => 'Hatchback', 'description' => 'Compact car with rear door'],
            ['name' => 'Minivan', 'description' => 'Family van'],
        ];

        foreach ($types as $type) {
            CarType::create($type);
        }
    }
}
