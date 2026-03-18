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
        $region = Region::create([
            'name' => 'Region III - Central Luzon',
            'code' => 'R3',
            'description' => 'Regional monitoring system for Central Luzon provinces',
        ]);

        // Create provinces
        $provinces = [
            ['name' => 'Aurora', 'code' => 'AUR'],
            ['name' => 'Bataan', 'code' => 'BAT'],
            ['name' => 'Bulacan', 'code' => 'BUL'],
            ['name' => 'Nueva Ecija', 'code' => 'NEC'],
            ['name' => 'Pampanga', 'code' => 'PAM'],
            ['name' => 'Tarlac', 'code' => 'TAR'],
            ['name' => 'Zambales', 'code' => 'ZAM'],
        ];

        foreach ($provinces as $province) {
            Province::create([
                'region_id' => $region->id,
                'name' => $province['name'],
                'code' => $province['code'],
            ]);
        }
    }
}
