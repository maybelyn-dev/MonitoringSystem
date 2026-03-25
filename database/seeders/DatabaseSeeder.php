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
        // Ensure region + provinces exist before dashboard queries run
        $this->call(RegionSeeder::class);

        // 1) Admin user
        User::updateOrCreate([
            'email' => 'datamonitoring123@gmail.com',
        ],[
            'name' => 'Admin User',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // 2) Additional sample users (optional, kept for development)
        User::updateOrCreate([
            'email' => 'dict.focal@example.com',
        ],[
            'name' => 'DICT Focal',
            'role' => 'focal',
            'agency_name' => 'DICT',
            'password' => Hash::make('password'),
        ]);

        User::updateOrCreate([
            'email' => 'psa.viewer@example.com',
        ],[
            'name' => 'PSA Viewer',
            'role' => 'focal_viewer',
            'password' => Hash::make('password'),
        ]);

        // 3) Agency records
        $agencyNames = [
            'Department of Health',
            'Department of Education',
            'Department of Agriculture',
            'Department of Public Works and Highways',
            'Department of Social Welfare and Development',
        ];

        foreach ($agencyNames as $agencyName) {
            \App\Models\Agency::updateOrCreate(
                ['agency_name' => $agencyName],
                ['province' => null, 'address' => null, 'contact' => null]
            );
        }

        // 4) Regional statistics (includes categories)
        $this->call(RegionalStatisticsSeeder::class);
    }
}
