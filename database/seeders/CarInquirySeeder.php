<?php

namespace Database\Seeders;

use App\Models\CarInquiry;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarInquirySeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        $users = User::all();

        $messages = [
            'Is this car still available? I would like to schedule a test drive.',
            'Can you provide more details about the service history?',
            'I am interested in this vehicle. What is your best price?',
            'Does this car have any warranty remaining?',
            'Can I see the vehicle inspection report?',
            'Is the price negotiable? I am a serious buyer.',
        ];

        foreach ($cars->random(min(15, $cars->count())) as $car) {
            CarInquiry::create([
                'car_id' => $car->id,
                'user_id' => $users->random()->id,
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber(),
                'message' => $messages[array_rand($messages)],
                'is_read' => fake()->boolean(60),
            ]);
        }
    }
}
