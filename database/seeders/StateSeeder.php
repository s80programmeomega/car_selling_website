<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['name' => 'California', 'code' => 'CA'],
            ['name' => 'Texas', 'code' => 'TX'],
            ['name' => 'Florida', 'code' => 'FL'],
            ['name' => 'New York', 'code' => 'NY'],
            ['name' => 'Illinois', 'code' => 'IL'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
