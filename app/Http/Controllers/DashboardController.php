<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\EconomicData;
use App\Models\Province;
use App\Models\Statistic;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        // Get Region III data
        $region = Region::where('code', 'R3')->first();
        $userProvinceId = Auth::user()?->province_id;
        $selectedProvinceId = $request->get('province_id') ?: $userProvinceId;
        $provinceNames = [
            'Aurora',
            'Bataan',
            'Bulacan',
            'Nueva Ecija',
            'Pampanga',
            'Tarlac',
            'Zambales',
        ];
        $provinces = Province::whereIn('name', $provinceNames)
            ->whereHas('region', fn ($q) => $q->where('code', 'R3'))
            ->orderBy('name')
            ->get()
            ->unique('name')
            ->values();
        $tableLabelMap = [
            '13.1' => 'Motor Vehicles',
            '16.2' => 'Banking Deposits',
            '16.3' => 'Banking Income',
        ];
        $years = range(2010, 2022);

        $selectedTable = $request->get('table') ?: '13.1';
        $requestedYear = $request->get('year');
        $fallbackYear = $selectedTable === '13.1'
            ? 2022
            : ($selectedTable === '16.2' ? 2020 : 2019);
        $selectedYear = in_array((int) $requestedYear, $years, true)
            ? (int) $requestedYear
            : $fallbackYear;

        $totalRecordsQuery = Statistic::query()
            ->where('table_reference', $selectedTable)
            ->where('year', $selectedYear);

        $totalRecords = 0.0;
        if (in_array($selectedTable, ['16.2', '16.3'], true)) {
            $totalRecordsQuery->whereHas('category', fn ($q) => $q->where('name', 'Total'));
        }
        if ($selectedProvinceId) {
            $totalRecordsQuery->where('province_id', $selectedProvinceId);
            $totalRecords = (float) $totalRecordsQuery->sum('value');
        } else {
            $totalRecordsQuery->whereIn('province_id', $provinces->pluck('id'));
            $totalRecords = (float) $totalRecordsQuery->sum('value');
        }
        $totalRecordsLabel = $selectedTable === '13.1'
            ? 'Total Registered Vehicles'
            : ($selectedTable === '16.2'
                ? 'Total Deposits (Billion Pesos)'
                : 'Total Banking Income (Billion Pesos)');
        $provinceHasData = $selectedProvinceId
            ? Statistic::where('province_id', $selectedProvinceId)
                ->where('table_reference', '13.1')
                ->where('year', $selectedYear)
                ->exists()
            : true;
        $provinceDataStatus = $provinceHasData ? null : 'Data not yet available';
        $trendUnitLabel = $selectedTable === '13.1' ? 'Units' : 'Billion Pesos';
        $trendLabels = $years;
        $trendValues = [];
        foreach ($years as $year) {
            $trendQuery = Statistic::query()
                ->where('table_reference', $selectedTable)
                ->where('year', $year);

            if ($selectedTable === '13.1') {
                $trendQuery->whereHas('category', fn ($q) => $q->whereIn('name', ['Private', 'For Hire', 'Government']));
            } else {
                $trendQuery->whereHas('category', fn ($q) => $q->where('name', 'Total'));
            }

            if ($selectedProvinceId) {
                $trendQuery->where('province_id', $selectedProvinceId);
                $trendValues[] = (float) $trendQuery->sum('value');
            } else {
                $trendQuery->whereIn('province_id', $provinces->pluck('id'));
                $trendValues[] = (float) $trendQuery->sum('value');
            }
        }

        if (!$region) {
            $metrics = [
                [
                    'label' => $totalRecordsLabel,
                    'value' => $selectedTable === '13.1'
                        ? number_format($totalRecords, 0)
                        : number_format($totalRecords, 1),
                    'icon' => 'fa-database',
                    'trend' => 'Region III',
                    'subtitle' => $tableLabelMap[$selectedTable] ?? $selectedTable,
                ],
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
                'latestIncomeData',
                'provinces',
                'selectedProvinceId',
                'provinceDataStatus',
                'years',
                'selectedYear',
                'selectedTable',
                'trendLabels',
                'trendValues',
                'trendUnitLabel'
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
        if ($selectedProvinceId) {
            $latestVehicleQuery->where('province_id', $selectedProvinceId);
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
        if ($selectedProvinceId) {
            $vehicleByProvinceQuery->where('province_id', $selectedProvinceId);
        }
        $vehicleByProvince = $vehicleByProvinceQuery->get();

        $vehicleChartLabels = $vehicleByProvince->map(fn ($row) => $row->province?->name)->filter()->values();
        $vehicleChartPrivate = $vehicleByProvince->map(fn ($row) => (int) $row->private_vehicles)->values();
        $vehicleChartForHire = $vehicleByProvince->map(fn ($row) => (int) $row->for_hire)->values();

        $bankingDistributionSource = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'banking')
            ->where('year', $selectedYear)
            ->first();

        // Banking institutions distribution (selected year)
        $bankingDistribution = [
            'Universal Banks' => $bankingDistributionSource?->universal_banks ?? 0,
            'Thrift Banks' => $bankingDistributionSource?->thrift_banks ?? 0,
            'Rural Banks' => $bankingDistributionSource?->rural_banks ?? 0,
        ];

        // Prepare metrics for dashboard
        $metrics = [
            [
                'label' => $totalRecordsLabel,
                'value' => $selectedTable === '13.1'
                    ? number_format($totalRecords, 0)
                    : number_format($totalRecords, 1),
                'icon' => 'fa-database',
                'trend' => 'Selected Table',
                    'subtitle' => $tableLabelMap[$selectedTable] ?? $selectedTable,
            ],
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
            'latestIncomeData',
            'provinces',
            'selectedProvinceId',
            'provinceDataStatus',
            'years',
            'selectedYear',
            'selectedTable',
            'trendLabels',
            'trendValues',
            'trendUnitLabel'
        ));
    }
}
