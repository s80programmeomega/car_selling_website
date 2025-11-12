<?php

namespace Database\Factories;

use App\Models\Maker;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' ' . fake()->numberBetween(100, 999),
            'maker_id' => Maker::factory(),
        ];
    }
}
