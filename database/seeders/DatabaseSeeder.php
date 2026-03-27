<?php

namespace Database\Seeders;

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
        
        // Seed master admin + agency users
        $this->call(UserSeeder::class);
    }
}
