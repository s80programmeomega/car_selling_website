<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Leather Seats', 'category' => 'comfort'],
            ['name' => 'Sunroof', 'category' => 'comfort'],
            ['name' => 'Navigation System', 'category' => 'technology'],
            ['name' => 'Backup Camera', 'category' => 'safety'],
            ['name' => 'Blind Spot Monitor', 'category' => 'safety'],
            ['name' => 'Adaptive Cruise Control', 'category' => 'technology'],
            ['name' => 'Heated Seats', 'category' => 'comfort'],
            ['name' => 'Apple CarPlay', 'category' => 'technology'],
            ['name' => 'Lane Departure Warning', 'category' => 'safety'],
            ['name' => 'Parking Sensors', 'category' => 'safety'],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
