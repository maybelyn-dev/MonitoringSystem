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
    }

    private function seedVehicleRegistrations(): void
    {
        $year = 2022;

        $vehicleData = [
            'Aurora' => [
                'Total' => 15397,
                'Private' => 14123,
                'For Hire' => 1060,
                'Government' => 214,
            ],
            'Bataan' => [
                'Total' => 91828,
                'Private' => 65063,
                'For Hire' => 25529,
                'Government' => 1236,
            ],
            'Bulacan' => [
                'Total' => 334688,
                'Private' => 317678,
                'For Hire' => 16079,
                'Government' => 931,
                'Diplomatic' => 0,
                'Exempt' => 78,
            ],
        ];

        foreach ($vehicleData as $province => $subCategories) {
            foreach ($subCategories as $subCategory => $value) {
                $this->upsertRecord(
                    $province,
                    'Vehicles',
                    $subCategory,
                    $year,
                    $value
                );
            }
        }
    }

    private function seedBankingLiabilities(): void
    {
        $year = 2020;
        $this->upsertRecord(
            'Region III',
            'Banking Liabilities',
            'Region III Total',
            $year,
            807.1
        );
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
