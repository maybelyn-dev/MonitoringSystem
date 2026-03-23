<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'datamonitoring123@gmail.com',
            'role' => 'admin',
            'agency_id' => 1,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'DICT Focal',
            'email' => 'dict.focal@example.com',
            'role' => 'focal',
            'agency_name' => 'DICT',
            'agency_id' => 1,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'PSA Viewer',
            'email' => 'psa.viewer@example.com',
            'role' => 'focal_viewer',
            'agency_id' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
