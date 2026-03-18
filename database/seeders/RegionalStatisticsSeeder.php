<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Province;
use App\Models\Region;
use App\Models\Statistic;
use Illuminate\Database\Seeder;

class RegionalStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region = Region::updateOrCreate(['name' => 'Region III']);

        Province::whereIn('name', ['Quezon', 'Region III'])->delete();

        $provinceNames = [
            'Aurora',
            'Bataan',
            'Bulacan',
            'Nueva Ecija',
            'Pampanga',
            'Tarlac',
            'Zambales',
        ];

        $provinces = [];
        foreach ($provinceNames as $name) {
            $provinces[$name] = Province::updateOrCreate(
                ['name' => $name, 'region_id' => $region->id]
            );
        }

        $regionTotal = Province::updateOrCreate(
            ['name' => 'Region III Total', 'region_id' => $region->id]
        );

        $private = Category::updateOrCreate(['name' => 'Private']);
        $forHire = Category::updateOrCreate(['name' => 'For Hire']);
        $government = Category::updateOrCreate(['name' => 'Government']);
        $total = Category::updateOrCreate(['name' => 'Total']);
        $universal = Category::updateOrCreate(['name' => 'Universal and Commercial Banks']);
        $thrift = Category::updateOrCreate(['name' => 'Thrift Banks']);
        $rural = Category::updateOrCreate(['name' => 'Rural and Cooperative Banks']);

        $vehicles = [
            'Aurora' => [
                2018 => ['Private' => 6259, 'For Hire' => 1498, 'Government' => 158],
                2019 => ['Private' => 2173, 'For Hire' => 2, 'Government' => 15],
                2020 => ['Private' => 12116, 'For Hire' => 1242, 'Government' => 170],
                2021 => ['Private' => 12045, 'For Hire' => 914, 'Government' => 189],
                2022 => ['Private' => 14123, 'For Hire' => 1060, 'Government' => 214],
            ],
            'Bataan' => [
                2018 => ['Private' => 39550, 'For Hire' => 19883, 'Government' => 1178],
                2019 => ['Private' => 44016, 'For Hire' => 22606, 'Government' => 948],
                2020 => ['Private' => 53264, 'For Hire' => 18738, 'Government' => 505],
                2021 => ['Private' => 52083, 'For Hire' => 17182, 'Government' => 293],
                2022 => ['Private' => 65063, 'For Hire' => 25529, 'Government' => 1236],
            ],
            'Bulacan' => [
                2018 => ['Private' => 272734, 'For Hire' => 23920, 'Government' => 882],
                2019 => ['Private' => 243275, 'For Hire' => 19358, 'Government' => 758],
                2020 => ['Private' => 237020, 'For Hire' => 17664, 'Government' => 811],
                2021 => ['Private' => 301822, 'For Hire' => 16625, 'Government' => 886],
                2022 => ['Private' => 317678, 'For Hire' => 16079, 'Government' => 931],
            ],
        ];

        $vehicleCategories = [
            'Private' => $private,
            'For Hire' => $forHire,
            'Government' => $government,
        ];

        foreach ($vehicles as $provinceName => $years) {
            foreach ($years as $year => $categories) {
                foreach ($categories as $categoryName => $value) {
                    Statistic::updateOrCreate(
                        [
                            'province_id' => $provinces[$provinceName]->id,
                            'category_id' => $vehicleCategories[$categoryName]->id,
                            'year' => $year,
                            'table_reference' => '13.1',
                        ],
                        [
                            'value' => $value,
                        ]
                    );
                }
            }
        }

        $bankingTotals = [
            '16.2' => [
                2020 => [
                    'Total' => 807.1,
                    'Universal and Commercial Banks' => 714.6,
                    'Thrift Banks' => 57.3,
                    'Rural and Cooperative Banks' => 35.3,
                ],
            ],
            '16.3' => [
                2019 => [
                    'Total' => 16.3,
                    'Universal and Commercial Banks' => 8.4,
                    'Thrift Banks' => 3.7,
                    'Rural and Cooperative Banks' => 4.2,
                ],
            ],
        ];

        $bankingCategories = [
            'Total' => $total,
            'Universal and Commercial Banks' => $universal,
            'Thrift Banks' => $thrift,
            'Rural and Cooperative Banks' => $rural,
        ];

        foreach ($bankingTotals as $tableRef => $years) {
            foreach ($years as $year => $rows) {
                foreach ($rows as $categoryName => $value) {
                    Statistic::updateOrCreate(
                        [
                            'province_id' => $regionTotal->id,
                            'category_id' => $bankingCategories[$categoryName]->id,
                            'year' => $year,
                            'table_reference' => $tableRef,
                        ],
                        [
                            'value' => $value,
                        ]
                    );
                }
            }
        }
    }
}
