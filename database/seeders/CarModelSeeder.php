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
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Prius'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Fit'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape', 'Bronco'],
            'Chevrolet' => ['Silverado', 'Malibu', 'Equinox', 'Tahoe', 'Camaro'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'M4'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE', 'S-Class'],
            'Audi' => ['A4', 'A6', 'Q5', 'Q7', 'e-tron'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Pathfinder', 'Maxima'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona'],
            'Kia' => ['Forte', 'Optima', 'Sportage', 'Sorento', 'Telluride'],
        ];

        foreach ($models as $makerName => $modelNames) {
            $maker = Maker::where('name', $makerName)->first();

            if ($maker) {
                foreach ($modelNames as $modelName) {
                    CarModel::create([
                        'name' => $modelName,
                        'maker_id' => $maker->id,
                    ]);
                }
            }
        }
    }
}
