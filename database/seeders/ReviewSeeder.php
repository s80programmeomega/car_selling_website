<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        $users = User::all();

        $comments = [
            'Great seller! Very responsive and honest about the car condition.',
            'Smooth transaction. The car was exactly as described.',
            'Professional and courteous. Highly recommend!',
            'Good experience overall. Car is in excellent condition.',
            'Fast communication and fair pricing.',
            
        ];

        foreach ($cars->random(min(10, $cars->count())) as $car) {
            $reviewer = $users->where('id', '!=', $car->owner_id)->random();

            Review::create([
                'reviewer_id' => $reviewer->id,
                'seller_id' => $car->owner_id,
                'car_id' => $car->id,
                'rating' => rand(3, 5),
                'comment' => $comments[array_rand($comments)],
            ]);
        }
    }
}
