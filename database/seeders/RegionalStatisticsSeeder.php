<?php

namespace Database\Seeders;

use App\Models\RegionalStatistic;
use Illuminate\Database\Seeder;

class RegionalStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedVehicleRegistrations();
        $this->seedBankingLiabilities();
        $this->seedOperatingIncome();
    }

    private function seedVehicleRegistrations(): void
    {
        $vehicleData = [
            'Aurora' => [
                2018 => ['Total' => 7915, 'Private' => 6259, 'For Hire' => 1498, 'Government' => 158, 'Diplomatic' => 0, 'Exempt' => 0],
                2019 => ['Total' => 2190, 'Private' => 2173, 'For Hire' => 2, 'Government' => 15, 'Diplomatic' => 0, 'Exempt' => 0],
                2020 => ['Total' => 13528, 'Private' => 12116, 'For Hire' => 1242, 'Government' => 170, 'Diplomatic' => 0, 'Exempt' => 0],
                2021 => ['Total' => 13149, 'Private' => 12045, 'For Hire' => 914, 'Government' => 189, 'Diplomatic' => 0, 'Exempt' => 1],
                2022 => ['Total' => 15397, 'Private' => 14123, 'For Hire' => 1060, 'Government' => 214, 'Diplomatic' => 0, 'Exempt' => 0],
            ],
            'Bataan' => [
                2018 => ['Total' => 60611, 'Private' => 39550, 'For Hire' => 19883, 'Government' => 1178, 'Diplomatic' => 0, 'Exempt' => 0],
                2019 => ['Total' => 67570, 'Private' => 44016, 'For Hire' => 22606, 'Government' => 948, 'Diplomatic' => 0, 'Exempt' => 0],
                2020 => ['Total' => 72507, 'Private' => 53264, 'For Hire' => 18738, 'Government' => 505, 'Diplomatic' => 0, 'Exempt' => 0],
                2021 => ['Total' => 69558, 'Private' => 52083, 'For Hire' => 17182, 'Government' => 293, 'Diplomatic' => 0, 'Exempt' => 0],
                2022 => ['Total' => 91828, 'Private' => 65063, 'For Hire' => 25529, 'Government' => 1236, 'Diplomatic' => 0, 'Exempt' => 0],
            ],
            'Bulacan' => [
                2018 => ['Total' => 297536, 'Private' => 272734, 'For Hire' => 23920, 'Government' => 882, 'Diplomatic' => 0, 'Exempt' => 0],
                2019 => ['Total' => 263391, 'Private' => 243275, 'For Hire' => 19358, 'Government' => 758, 'Diplomatic' => 0, 'Exempt' => 0],
                2020 => ['Total' => 255495, 'Private' => 237020, 'For Hire' => 17664, 'Government' => 811, 'Diplomatic' => 0, 'Exempt' => 0],
                2021 => ['Total' => 319333, 'Private' => 301822, 'For Hire' => 16625, 'Government' => 886, 'Diplomatic' => 0, 'Exempt' => 0],
                2022 => ['Total' => 334688, 'Private' => 317678, 'For Hire' => 16079, 'Government' => 931, 'Diplomatic' => 0, 'Exempt' => 0],
            ],
            'Region III' => [
                2018 => ['Total' => 1345337, 'Private' => 1202683, 'For Hire' => 134096, 'Government' => 8179, 'Diplomatic' => 0, 'Exempt' => 379],
                2019 => ['Total' => 1467729, 'Private' => 1331152, 'For Hire' => 128213, 'Government' => 8090, 'Diplomatic' => 0, 'Exempt' => 274],
                2020 => ['Total' => 1291791, 'Private' => 1177391, 'For Hire' => 105782, 'Government' => 8350, 'Diplomatic' => 0, 'Exempt' => 268],
                2021 => ['Total' => 1378438, 'Private' => 1269381, 'For Hire' => 100577, 'Government' => 8207, 'Diplomatic' => 0, 'Exempt' => 273],
                2022 => ['Total' => 1429698, 'Private' => 1317120, 'For Hire' => 103799, 'Government' => 8701, 'Diplomatic' => 0, 'Exempt' => 78],
            ],
        ];

        foreach ($vehicleData as $province => $years) {
            foreach ($years as $year => $subCategories) {
                foreach ($subCategories as $subCategory => $value) {
                    $this->upsertRecord($province, 'Vehicles', $subCategory, $year, $value);
                }
            }
        }
    }

    private function seedBankingLiabilities(): void
    {
        $bankingRows = [
            2011 => ['Region III Total' => 269.6, 'Universal and Commercial Banks' => 217.1, 'Thrift Banks' => 32.0, 'Rural and Cooperative Banks' => 20.4],
            2012 => ['Region III Total' => 281.6, 'Universal and Commercial Banks' => 232.1, 'Thrift Banks' => 29.7, 'Rural and Cooperative Banks' => 19.9],
            2013 => ['Region III Total' => 337.2, 'Universal and Commercial Banks' => 283.9, 'Thrift Banks' => 34.2, 'Rural and Cooperative Banks' => 19.1],
            2014 => ['Region III Total' => 390.4, 'Universal and Commercial Banks' => 335.8, 'Thrift Banks' => 35.4, 'Rural and Cooperative Banks' => 19.2],
            2015 => ['Region III Total' => 432.5, 'Universal and Commercial Banks' => 372.7, 'Thrift Banks' => 39.2, 'Rural and Cooperative Banks' => 20.6],
            2016 => ['Region III Total' => 527.3, 'Universal and Commercial Banks' => 459.3, 'Thrift Banks' => 45.2, 'Rural and Cooperative Banks' => 22.8],
            2017 => ['Region III Total' => 601.8, 'Universal and Commercial Banks' => 526.0, 'Thrift Banks' => 51.7, 'Rural and Cooperative Banks' => 24.2],
            2018 => ['Region III Total' => 668.3, 'Universal and Commercial Banks' => 579.4, 'Thrift Banks' => 57.8, 'Rural and Cooperative Banks' => 31.0],
            2019 => ['Region III Total' => 762.3, 'Universal and Commercial Banks' => 668.5, 'Thrift Banks' => 62.0, 'Rural and Cooperative Banks' => 31.8],
            2020 => ['Region III Total' => 807.1, 'Universal and Commercial Banks' => 714.6, 'Thrift Banks' => 57.3, 'Rural and Cooperative Banks' => 35.3],
        ];

        foreach ($bankingRows as $year => $subCategories) {
            foreach ($subCategories as $subCategory => $value) {
                $this->upsertRecord('Region III', 'Banking Liabilities', $subCategory, $year, $value);
            }
        }
    }

    private function seedOperatingIncome(): void
    {
        $incomeRows = [
            2010 => ['Region III Total' => 6.2, 'Universal and Commercial Banks' => 1.1, 'Thrift Banks' => 1.6, 'Rural and Cooperative Banks' => 3.4],
            2011 => ['Region III Total' => 8.5, 'Universal and Commercial Banks' => 3.1, 'Thrift Banks' => 1.9, 'Rural and Cooperative Banks' => 3.5],
            2012 => ['Region III Total' => 6.6, 'Universal and Commercial Banks' => 1.5, 'Thrift Banks' => 1.8, 'Rural and Cooperative Banks' => 3.3],
            2013 => ['Region III Total' => 11.4, 'Universal and Commercial Banks' => 6.4, 'Thrift Banks' => 1.9, 'Rural and Cooperative Banks' => 3.2],
            2014 => ['Region III Total' => 9.8, 'Universal and Commercial Banks' => 4.1, 'Thrift Banks' => 2.4, 'Rural and Cooperative Banks' => 3.4],
            2015 => ['Region III Total' => 11.8, 'Universal and Commercial Banks' => 5.6, 'Thrift Banks' => 3.0, 'Rural and Cooperative Banks' => 3.3],
            2016 => ['Region III Total' => 13.9, 'Universal and Commercial Banks' => 6.3, 'Thrift Banks' => 3.9, 'Rural and Cooperative Banks' => 3.7],
            2017 => ['Region III Total' => 13.3, 'Universal and Commercial Banks' => 5.3, 'Thrift Banks' => 4.2, 'Rural and Cooperative Banks' => 3.8],
            2018 => ['Region III Total' => 16.2, 'Universal and Commercial Banks' => 8.2, 'Thrift Banks' => 4.0, 'Rural and Cooperative Banks' => 4.0],
            2019 => ['Region III Total' => 16.3, 'Universal and Commercial Banks' => 8.4, 'Thrift Banks' => 3.7, 'Rural and Cooperative Banks' => 4.2],
        ];

        foreach ($incomeRows as $year => $subCategories) {
            foreach ($subCategories as $subCategory => $value) {
                $this->upsertRecord('Region III', 'Operating Income', $subCategory, $year, $value);
            }
        }
    }

    private function upsertRecord(string $province, string $category, string $subCategory, int $year, ?float $value): void
    {
        RegionalStatistic::updateOrCreate(
            [
                'province' => $province,
                'category' => $category,
                'sub_category' => $subCategory,
                'year' => $year,
            ],
            [
                'value' => $value,
            ]
        );
    }
}
