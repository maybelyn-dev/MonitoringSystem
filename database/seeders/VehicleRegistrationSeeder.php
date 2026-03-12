<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Province;
use App\Models\VehicleRegistration;
use Illuminate\Database\Seeder;

class VehicleRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region = Region::where('code', 'R3')->first();

        if (!$region) {
            return;
        }

        // 2022 Vehicle Registration Data by Province (official table; seed only values present)
        $vehicleData = [
            [
                'province' => 'Aurora',
                'private' => 14123,
                'for_hire' => 1060,
                'government' => 214,
                'diplomatic' => 0,
                'exempt' => 0,
                'total' => 15397,
            ],
            [
                'province' => 'Bataan',
                'private' => 65063,
                'for_hire' => 25529,
                'government' => 1236,
                'diplomatic' => 0,
                'exempt' => 0,
                'total' => 91828,
            ],
            [
                'province' => 'Bulacan',
                'private' => 317678,
                'for_hire' => 16079,
                'government' => 931,
                'diplomatic' => 0,
                'exempt' => 0,
                'total' => 334688,
            ],
        ];

        foreach ($vehicleData as $data) {
            $province = Province::where('name', $data['province'])->first();

            if ($province) {
                VehicleRegistration::updateOrCreate(
                    [
                        'region_id' => $region->id,
                        'province_id' => $province->id,
                        'year' => 2022,
                    ],
                    [
                        'classification' => 'total',
                        'private_vehicles' => $data['private'],
                        'for_hire' => $data['for_hire'],
                        'government' => $data['government'],
                        'diplomatic' => $data['diplomatic'],
                        'exempt' => $data['exempt'],
                        'total' => $data['total'],
                    ]
                );
            }
        }

        // Region III Total for 2022 (official)
        VehicleRegistration::updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => null,
                'year' => 2022,
            ],
            [
                'classification' => 'total',
                'private_vehicles' => 1317120,
                'for_hire' => 103799,
                'government' => 8701,
                'diplomatic' => 0,
                'exempt' => 78,
                'total' => 1429698,
            ]
        );
    }
}
