<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\EconomicData;
use Illuminate\Database\Seeder;

class EconomicDataSeeder extends Seeder
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

        // Banking Liabilities Data (2011-2020) - in billions
        $bankingData = [
            ['year' => 2011, 'banking_liabilities' => 269.6, 'universal_banks' => 217.1, 'thrift_banks' => 32.0, 'rural_banks' => 20.4],
            ['year' => 2012, 'banking_liabilities' => 281.6, 'universal_banks' => 232.1, 'thrift_banks' => 29.7, 'rural_banks' => 19.9],
            ['year' => 2013, 'banking_liabilities' => 337.2, 'universal_banks' => 283.9, 'thrift_banks' => 34.2, 'rural_banks' => 19.1],
            ['year' => 2014, 'banking_liabilities' => 390.4, 'universal_banks' => 335.8, 'thrift_banks' => 35.4, 'rural_banks' => 19.2],
            ['year' => 2015, 'banking_liabilities' => 432.5, 'universal_banks' => 372.7, 'thrift_banks' => 39.2, 'rural_banks' => 20.6],
            ['year' => 2016, 'banking_liabilities' => 527.3, 'universal_banks' => 459.3, 'thrift_banks' => 45.2, 'rural_banks' => 22.8],
            ['year' => 2017, 'banking_liabilities' => 601.8, 'universal_banks' => 526.0, 'thrift_banks' => 51.7, 'rural_banks' => 24.2],
            ['year' => 2018, 'banking_liabilities' => 668.3, 'universal_banks' => 579.4, 'thrift_banks' => 57.8, 'rural_banks' => 31.0],
            ['year' => 2019, 'banking_liabilities' => 762.3, 'universal_banks' => 668.5, 'thrift_banks' => 62.0, 'rural_banks' => 31.8],
            ['year' => 2020, 'banking_liabilities' => 807.1, 'universal_banks' => 714.6, 'thrift_banks' => 57.3, 'rural_banks' => 35.3],
        ];

        foreach ($bankingData as $data) {
            EconomicData::updateOrCreate(
                [
                    'region_id' => $region->id,
                    'province_id' => null,
                    'year' => $data['year'],
                    'data_type' => 'banking',
                ],
                [
                    'banking_liabilities' => $data['banking_liabilities'],
                    'universal_banks' => $data['universal_banks'],
                    'thrift_banks' => $data['thrift_banks'],
                    'rural_banks' => $data['rural_banks'],
                ]
            );
        }

        // Operating Income Data (2010-2019) - in billions
        $incomeData = [
            ['year' => 2010, 'operating_income' => 6.2],
            ['year' => 2011, 'operating_income' => 8.5],
            ['year' => 2012, 'operating_income' => 6.6],
            ['year' => 2013, 'operating_income' => 11.4],
            ['year' => 2014, 'operating_income' => 9.8],
            ['year' => 2015, 'operating_income' => 11.8],
            ['year' => 2016, 'operating_income' => 13.9],
            ['year' => 2017, 'operating_income' => 13.3],
            ['year' => 2018, 'operating_income' => 16.2],
            ['year' => 2019, 'operating_income' => 16.3],
        ];

        foreach ($incomeData as $data) {
            EconomicData::updateOrCreate(
                [
                    'region_id' => $region->id,
                    'province_id' => null,
                    'year' => $data['year'],
                    'data_type' => 'income',
                ],
                [
                    'operating_income' => $data['operating_income'],
                ]
            );
        }
    }
}
