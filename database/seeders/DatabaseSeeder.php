<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed regions and provinces first
        $this->call(RegionSeeder::class);
        
        // Seed economic data
        $this->call(EconomicDataSeeder::class);
        
        // Seed vehicle registration data
        $this->call(VehicleRegistrationSeeder::class);

        // Seed regional statistics dashboard data
        $this->call(RegionalStatisticsSeeder::class);

        // Seed agencies
        $this->call(AgencySeeder::class);

        // Create test users for each agency
        User::factory()->create([
            'name' => 'DICT Admin',
            'email' => 'dict@example.com',
            'agency_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'DOH Admin',
            'email' => 'doh@example.com',
            'agency_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'DPWH Admin',
            'email' => 'dpwh@example.com',
            'agency_id' => 3,
        ]);
    }
}
