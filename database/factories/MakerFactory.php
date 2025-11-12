<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MakerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW',
                'Mercedes-Benz', 'Audi', 'Nissan', 'Hyundai', 'Kia',
                'Volkswagen', 'Mazda', 'Subaru', 'Lexus', 'Porsche'
            ]),
        ];
    }
}
