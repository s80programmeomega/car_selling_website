<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\Maker;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape'],
            'Chevrolet' => ['Silverado', 'Malibu', 'Equinox', 'Tahoe'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5'],
        ];

        foreach ($models as $makerName => $modelNames) {
            $maker = Maker::where('name', $makerName)->first();
            foreach ($modelNames as $modelName) {
                CarModel::create([
                    'name' => $modelName,
                    'maker_id' => $maker->id,
                ]);
            }
        }
    }
}
