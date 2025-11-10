<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@email.com',
            'role' => 'admin',
        ]);

        // Call other seeders in order
        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            MakerSeeder::class,
            CarModelSeeder::class,
            CarTypeSeeder::class,
            FuelTypeSeeder::class,
            FeatureSeeder::class,
            CarSeeder::class,
            CarImageSeeder::class,
            CarInquirySeeder::class,  // ← Added
            ReviewSeeder::class,       // ← Added
        ]);
    }
}
