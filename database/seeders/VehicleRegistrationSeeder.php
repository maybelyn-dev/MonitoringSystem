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

        $regionTotals = [
            2018 => ['private' => 1202683, 'for_hire' => 134096, 'government' => 8179, 'diplomatic' => 0, 'exempt' => 379, 'total' => 1345337],
            2019 => ['private' => 1331152, 'for_hire' => 128213, 'government' => 8090, 'diplomatic' => 0, 'exempt' => 274, 'total' => 1467729],
            2020 => ['private' => 1177391, 'for_hire' => 105782, 'government' => 8350, 'diplomatic' => 0, 'exempt' => 268, 'total' => 1291791],
            2021 => ['private' => 1269381, 'for_hire' => 100577, 'government' => 8207, 'diplomatic' => 0, 'exempt' => 273, 'total' => 1378438],
            2022 => ['private' => 1317120, 'for_hire' => 103799, 'government' => 8701, 'diplomatic' => 0, 'exempt' => 78, 'total' => 1429698],
        ];

        foreach ($regionTotals as $year => $data) {
            $this->upsertRegistration($region->id, null, $year, $data);
        }

        $provinceData = [
            'Aurora' => [
                2018 => ['private' => 6259, 'for_hire' => 1498, 'government' => 158, 'diplomatic' => 0, 'exempt' => 0, 'total' => 7915],
                2019 => ['private' => 2173, 'for_hire' => 2, 'government' => 15, 'diplomatic' => 0, 'exempt' => 0, 'total' => 2190],
                2020 => ['private' => 12116, 'for_hire' => 1242, 'government' => 170, 'diplomatic' => 0, 'exempt' => 0, 'total' => 13528],
                2021 => ['private' => 12045, 'for_hire' => 914, 'government' => 189, 'diplomatic' => 0, 'exempt' => 1, 'total' => 13149],
                2022 => ['private' => 14123, 'for_hire' => 1060, 'government' => 214, 'diplomatic' => 0, 'exempt' => 0, 'total' => 15397],
            ],
            'Bataan' => [
                2018 => ['private' => 39550, 'for_hire' => 19883, 'government' => 1178, 'diplomatic' => 0, 'exempt' => 0, 'total' => 60611],
                2019 => ['private' => 44016, 'for_hire' => 22606, 'government' => 948, 'diplomatic' => 0, 'exempt' => 0, 'total' => 67570],
                2020 => ['private' => 53264, 'for_hire' => 18738, 'government' => 505, 'diplomatic' => 0, 'exempt' => 0, 'total' => 72507],
                2021 => ['private' => 52083, 'for_hire' => 17182, 'government' => 293, 'diplomatic' => 0, 'exempt' => 0, 'total' => 69558],
                2022 => ['private' => 65063, 'for_hire' => 25529, 'government' => 1236, 'diplomatic' => 0, 'exempt' => 0, 'total' => 91828],
            ],
            'Bulacan' => [
                2018 => ['private' => 272734, 'for_hire' => 23920, 'government' => 882, 'diplomatic' => 0, 'exempt' => 0, 'total' => 297536],
                2019 => ['private' => 243275, 'for_hire' => 19358, 'government' => 758, 'diplomatic' => 0, 'exempt' => 0, 'total' => 263391],
                2020 => ['private' => 237020, 'for_hire' => 17664, 'government' => 811, 'diplomatic' => 0, 'exempt' => 0, 'total' => 255495],
                2021 => ['private' => 301822, 'for_hire' => 16625, 'government' => 886, 'diplomatic' => 0, 'exempt' => 0, 'total' => 319333],
                2022 => ['private' => 317678, 'for_hire' => 16079, 'government' => 931, 'diplomatic' => 0, 'exempt' => 0, 'total' => 334688],
            ],
        ];

        foreach ($provinceData as $provinceName => $years) {
            $province = Province::where('name', $provinceName)->first();
            if (!$province) {
                continue;
            }

            foreach ($years as $year => $data) {
                $this->upsertRegistration($region->id, $province->id, $year, $data);
            }
        }
    }

    private function upsertRegistration(int $regionId, ?int $provinceId, int $year, array $data): void
    {
        VehicleRegistration::updateOrCreate(
            [
                'region_id' => $regionId,
                'province_id' => $provinceId,
                'year' => $year,
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
