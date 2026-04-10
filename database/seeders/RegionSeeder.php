<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Province;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Region III
        $region = Region::updateOrCreate(
            ['code' => 'R3'],
            [
                'name' => 'Region III - Central Luzon',
                'description' => 'Regional monitoring system for Central Luzon provinces',
            ]
        );

        // Create provinces
        $provinces = [
            ['name' => 'Aurora', 'code' => 'AUR', 'data_status' => 'active'],
            ['name' => 'Bataan', 'code' => 'BAT', 'data_status' => 'active'],
            ['name' => 'Bulacan', 'code' => 'BUL', 'data_status' => 'active'],
            ['name' => 'Nueva Ecija', 'code' => 'NEC', 'data_status' => 'pending'],
            ['name' => 'Pampanga', 'code' => 'PAM', 'data_status' => 'pending'],
            ['name' => 'Tarlac', 'code' => 'TAR', 'data_status' => 'pending'],
            ['name' => 'Zambales', 'code' => 'ZAM', 'data_status' => 'pending'],
        ];

        foreach ($provinces as $province) {
            Province::updateOrCreate(
                ['region_id' => $region->id, 'name' => $province['name']],
                [
                    'code' => $province['code'],
                    'data_status' => $province['data_status'],
                ]
            );
        }
    }
}
