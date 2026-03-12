<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\EconomicData;
use App\Models\VehicleRegistration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function formatVehicleCount(?float $value): string
    {
        $count = (float) ($value ?? 0);
        if ($count >= 1000000) {
            $millions = $count / 1000000;
            $formatted = number_format($millions, 1);
            $formatted = rtrim(rtrim($formatted, '0'), '.');
            return $formatted . 'M';
        }

        return number_format($count, 0);
    }

    /**
     * Display the dashboard with real economic data
     */
    public function index()
    {
        // Get Region III data
        $region = Region::where('code', 'R3')->first();
        $userProvinceId = Auth::user()?->province_id;

        if (!$region) {
            $metrics = [
                [
                    'label' => 'Total Banking Liabilities',
                    'value' => "\u{20B1}807.1B",
                    'icon' => 'fa-bank',
                    'trend' => '+18.5%',
                    'subtitle' => '2020 Data',
                ],
                [
                    'label' => 'Motor Vehicles Registered',
                    'value' => '1.4M',
                    'icon' => 'fa-car',
                    'trend' => '+3.7%',
                    'subtitle' => '2022 Data',
                ],
            ];

            $bankingTrend = collect();
            $incomeTrend = collect();
            $vehicleByProvince = collect();
            $vehicleChartLabels = collect();
            $vehicleChartPrivate = collect();
            $vehicleChartForHire = collect();
            $bankingDistribution = [];
            $latestBankingData = null;
            $latestVehicleData = null;
            $latestIncomeData = null;

            return view('pages.dashboard', compact(
                'metrics',
                'bankingTrend',
                'incomeTrend',
                'vehicleByProvince',
                'vehicleChartLabels',
                'vehicleChartPrivate',
                'vehicleChartForHire',
                'bankingDistribution',
                'latestBankingData',
                'latestVehicleData',
                'latestIncomeData'
            ));
        }

        // Get latest banking data (2020)
        $latestBankingData = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'banking')
            ->where('year', 2020)
            ->first();

        // Get latest vehicle registration data (2022); if user selected a province, scope to that province.
        $latestVehicleQuery = VehicleRegistration::where('region_id', $region->id)
            ->where('year', 2022);
        if ($userProvinceId) {
            $latestVehicleQuery->where('province_id', $userProvinceId);
        } else {
            $latestVehicleQuery->whereNull('province_id');
        }
        $latestVehicleData = $latestVehicleQuery->first();

        // Get latest operating income (2019)
        $latestIncomeData = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'income')
            ->where('year', 2019)
            ->first();

        // Banking trend data (2011-2020)
        $bankingTrend = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'banking')
            ->whereBetween('year', [2011, 2020])
            ->orderBy('year')
            ->get();

        // Operating income trend data (2010-2019)
        $incomeTrend = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'income')
            ->whereBetween('year', [2010, 2019])
            ->orderBy('year')
            ->get();

        // Vehicle registration by province (2022); if a province is selected, show only that province's data.
        $vehicleByProvinceQuery = VehicleRegistration::where('region_id', $region->id)
            ->whereNotNull('province_id')
            ->where('year', 2022)
            ->with('province');
        if ($userProvinceId) {
            $vehicleByProvinceQuery->where('province_id', $userProvinceId);
        }
        $vehicleByProvince = $vehicleByProvinceQuery->get();

        $vehicleChartLabels = $vehicleByProvince->map(fn ($row) => $row->province?->name)->filter()->values();
        $vehicleChartPrivate = $vehicleByProvince->map(fn ($row) => (int) $row->private_vehicles)->values();
        $vehicleChartForHire = $vehicleByProvince->map(fn ($row) => (int) $row->for_hire)->values();

        // Banking institutions distribution (2020)
        $bankingDistribution = [
            'Universal Banks' => $latestBankingData?->universal_banks ?? 0,
            'Thrift Banks' => $latestBankingData?->thrift_banks ?? 0,
            'Rural Banks' => $latestBankingData?->rural_banks ?? 0,
        ];

        // Prepare metrics for dashboard
        $metrics = [
            [
                'label' => 'Total Banking Liabilities',
                'value' => "\u{20B1}" . number_format($latestBankingData?->banking_liabilities ?? 0, 1) . 'B',
                'icon' => 'fa-bank',
                'trend' => '+18.5%',
                'subtitle' => '2020 Data',
            ],
            [
                'label' => 'Motor Vehicles Registered',
                'value' => $this->formatVehicleCount($latestVehicleData?->total),
                'icon' => 'fa-car',
                'trend' => '+3.7%',
                'subtitle' => '2022 Data',
            ],
            [
                'label' => 'Operating Income',
                'value' => "\u{20B1}" . number_format($latestIncomeData?->operating_income ?? 0, 1) . 'B',
                'icon' => 'fa-chart-line',
                'trend' => '+0.6%',
                'subtitle' => '2019 Data',
            ],
            [
                'label' => 'Universal Banks',
                'value' => number_format($latestBankingData?->universal_banks ?? 0, 1),
                'icon' => 'fa-building',
                'trend' => '+6.9%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Thrift Banks',
                'value' => number_format($latestBankingData?->thrift_banks ?? 0, 1),
                'icon' => 'fa-piggy-bank',
                'trend' => '-7.7%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Rural Banks',
                'value' => number_format($latestBankingData?->rural_banks ?? 0, 1),
                'icon' => 'fa-leaf',
                'trend' => '+12.7%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Private Vehicles',
                'value' => $this->formatVehicleCount($latestVehicleData?->private_vehicles),
                'icon' => 'fa-car-side',
                'trend' => '+4.2%',
                'subtitle' => '2022 Data',
            ],
        ];

        return view('pages.dashboard', compact(
            'metrics',
            'bankingTrend',
            'incomeTrend',
            'vehicleByProvince',
            'vehicleChartLabels',
            'vehicleChartPrivate',
            'vehicleChartForHire',
            'bankingDistribution',
            'latestBankingData',
            'latestVehicleData',
            'latestIncomeData'
        ));
    }
}
