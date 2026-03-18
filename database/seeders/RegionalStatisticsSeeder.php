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
        $region = Region::updateOrCreate(
            ['code' => 'R3'],
            [
                'name' => 'Region III',
                'description' => 'Regional monitoring system for Central Luzon provinces',
            ]
        );

        $provinceCatalog = [
            'Aurora' => 'AUR',
            'Bataan' => 'BAT',
            'Bulacan' => 'BUL',
            'Nueva Ecija' => 'NEC',
            'Pampanga' => 'PAM',
            'Tarlac' => 'TAR',
            'Zambales' => 'ZAM',
        ];

        // Ensure only the seven provinces exist for Region III.
        Province::where('region_id', $region->id)
            ->whereNotIn('name', array_keys($provinceCatalog))
            ->delete();

        $provinces = [];
        foreach ($provinceCatalog as $name => $code) {
            $provinces[$name] = Province::updateOrCreate(
                ['name' => $name, 'region_id' => $region->id],
                ['code' => $code]
            );
        }

        $categoryNames = [
            'Private',
            'For Hire',
            'Government',
            'Universal and Commercial Banks',
            'Thrift Banks',
            'Rural and Cooperative Banks',
            'Total',
        ];

        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[$name] = Category::updateOrCreate(['name' => $name]);
        }

        $allYears = range(2010, 2022);

        $vehicleData = [
            'Bulacan' => [
                2022 => ['Private' => 317678, 'For Hire' => 16079, 'Government' => 931],
            ],
        ];

        foreach ($provinces as $provinceName => $province) {
            foreach ($allYears as $year) {
                foreach (['Private', 'For Hire', 'Government'] as $category) {
                    $value = $vehicleData[$provinceName][$year][$category] ?? 0;
                    Statistic::updateOrCreate(
                        [
                            'province_id' => $province->id,
                            'category_id' => $categories[$category]->id,
                            'year' => $year,
                            'table_reference' => '13.1',
                        ],
                        ['value' => $value]
                    );
                }
            }
        }

        $depositData = [
            2011 => ['Total' => 269.6, 'Universal and Commercial Banks' => 217.1, 'Thrift Banks' => 32.0, 'Rural and Cooperative Banks' => 20.4],
            2012 => ['Total' => 281.6, 'Universal and Commercial Banks' => 232.1, 'Thrift Banks' => 29.7, 'Rural and Cooperative Banks' => 19.9],
            2013 => ['Total' => 337.2, 'Universal and Commercial Banks' => 283.9, 'Thrift Banks' => 34.2, 'Rural and Cooperative Banks' => 19.1],
            2014 => ['Total' => 390.4, 'Universal and Commercial Banks' => 335.8, 'Thrift Banks' => 35.4, 'Rural and Cooperative Banks' => 19.2],
            2015 => ['Total' => 432.5, 'Universal and Commercial Banks' => 372.7, 'Thrift Banks' => 39.2, 'Rural and Cooperative Banks' => 20.6],
            2016 => ['Total' => 527.3, 'Universal and Commercial Banks' => 459.3, 'Thrift Banks' => 45.2, 'Rural and Cooperative Banks' => 22.8],
            2017 => ['Total' => 601.8, 'Universal and Commercial Banks' => 526.0, 'Thrift Banks' => 51.7, 'Rural and Cooperative Banks' => 24.2],
            2018 => ['Total' => 668.3, 'Universal and Commercial Banks' => 579.4, 'Thrift Banks' => 57.8, 'Rural and Cooperative Banks' => 31.0],
            2019 => ['Total' => 762.3, 'Universal and Commercial Banks' => 668.5, 'Thrift Banks' => 62.0, 'Rural and Cooperative Banks' => 31.8],
            2020 => ['Total' => 807.1, 'Universal and Commercial Banks' => 714.6, 'Thrift Banks' => 57.3, 'Rural and Cooperative Banks' => 35.3],
        ];

        foreach ($provinces as $provinceName => $province) {
            foreach ($allYears as $year) {
                $yearData = ($provinceName === 'Bulacan') ? ($depositData[$year] ?? []) : [];
                foreach (['Universal and Commercial Banks', 'Thrift Banks', 'Rural and Cooperative Banks', 'Total'] as $category) {
                    $value = $yearData[$category] ?? 0;
                    Statistic::updateOrCreate(
                        [
                            'province_id' => $province->id,
                            'category_id' => $categories[$category]->id,
                            'year' => $year,
                            'table_reference' => '16.2',
                        ],
                        ['value' => $value]
                    );
                }
            }
        }

        $incomeData = [
            2010 => ['Total' => 6.2, 'Universal and Commercial Banks' => 1.1, 'Thrift Banks' => 1.6, 'Rural and Cooperative Banks' => 3.4],
            2011 => ['Total' => 8.5, 'Universal and Commercial Banks' => 3.1, 'Thrift Banks' => 1.9, 'Rural and Cooperative Banks' => 3.5],
            2012 => ['Total' => 6.6, 'Universal and Commercial Banks' => 1.5, 'Thrift Banks' => 1.8, 'Rural and Cooperative Banks' => 3.3],
            2013 => ['Total' => 11.4, 'Universal and Commercial Banks' => 6.4, 'Thrift Banks' => 1.9, 'Rural and Cooperative Banks' => 3.2],
            2014 => ['Total' => 9.8, 'Universal and Commercial Banks' => 4.1, 'Thrift Banks' => 2.4, 'Rural and Cooperative Banks' => 3.4],
            2015 => ['Total' => 11.8, 'Universal and Commercial Banks' => 5.6, 'Thrift Banks' => 3.0, 'Rural and Cooperative Banks' => 3.3],
            2016 => ['Total' => 13.9, 'Universal and Commercial Banks' => 6.3, 'Thrift Banks' => 3.9, 'Rural and Cooperative Banks' => 3.7],
            2017 => ['Total' => 13.3, 'Universal and Commercial Banks' => 5.3, 'Thrift Banks' => 4.2, 'Rural and Cooperative Banks' => 3.8],
            2018 => ['Total' => 16.2, 'Universal and Commercial Banks' => 8.2, 'Thrift Banks' => 4.0, 'Rural and Cooperative Banks' => 4.0],
            2019 => ['Total' => 16.3, 'Universal and Commercial Banks' => 8.4, 'Thrift Banks' => 3.7, 'Rural and Cooperative Banks' => 4.2],
        ];

        foreach ($provinces as $provinceName => $province) {
            foreach ($allYears as $year) {
                $yearData = ($provinceName === 'Bulacan') ? ($incomeData[$year] ?? []) : [];
                foreach (['Universal and Commercial Banks', 'Thrift Banks', 'Rural and Cooperative Banks', 'Total'] as $category) {
                    $value = $yearData[$category] ?? 0;
                    Statistic::updateOrCreate(
                        [
                            'province_id' => $province->id,
                            'category_id' => $categories[$category]->id,
                            'year' => $year,
                            'table_reference' => '16.3',
                        ],
                        ['value' => $value]
                    );
                }
            }
        }
    }
}
