<?php

namespace Database\Seeders;

use App\Models\Maker;
use Illuminate\Database\Seeder;

class MakerSeeder extends Seeder
{
    public function run(): void
    {
        $makers = [
            'Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW',
            'Mercedes-Benz', 'Audi', 'Nissan', 'Hyundai', 'Kia'
        ];

        foreach ($makers as $maker) {
            Maker::create(['name' => $maker]);
        }
    }
}
