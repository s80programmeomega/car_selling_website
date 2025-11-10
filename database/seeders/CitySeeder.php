<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            'CA' => ['Los Angeles', 'San Francisco', 'San Diego'],
            'TX' => ['Houston', 'Dallas', 'Austin'],
            'FL' => ['Miami', 'Orlando', 'Tampa'],
            'NY' => ['New York City', 'Buffalo', 'Rochester'],
            'IL' => ['Chicago', 'Aurora', 'Naperville'],
        ];

        foreach ($cities as $stateCode => $cityNames) {
            $state = State::where('code', $stateCode)->first();
            foreach ($cityNames as $cityName) {
                City::create([
                    'name' => $cityName,
                    'state_id' => $state->id,
                ]);
            }
        }
    }
}
