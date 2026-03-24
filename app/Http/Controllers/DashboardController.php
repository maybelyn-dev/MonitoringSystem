<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\EconomicData;
use App\Models\Province;
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
        $region = Region::firstOrCreate(
            ['code' => 'R3'],
            ['name' => 'Region III']
        );
        $user = Auth::user();
        $userProvinceId = $user?->province_id;
        $requestedProvinceId = $request->get('province_id');
        $provinceNames = [
            'Aurora',
            'Bataan',
            'Bulacan',
            'Nueva Ecija',
            'Pampanga',
            'Tarlac',
            'Zambales',
        ];
        $provinces = collect($provinceNames)->map(function ($name) use ($region) {
            return Province::firstOrCreate(
                ['name' => $name],
                ['region_id' => $region->id]
            );
        })->values();
        if ($user?->isAdmin()) {
            $selectedProvinceId = $requestedProvinceId !== null && $requestedProvinceId !== ''
                ? (int) $requestedProvinceId
                : null;
        } else {
            $selectedProvinceId = $requestedProvinceId !== null && $requestedProvinceId !== ''
                ? (int) $requestedProvinceId
                : $userProvinceId;
        }
        if ($selectedProvinceId && !$provinces->pluck('id')->contains((int) $selectedProvinceId)) {
            $selectedProvinceId = $user?->isAdmin() ? null : $userProvinceId;
        }
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

        $totalRecords = 0.0;
        $totalRecordsLabel = $selectedTable === '13.1'
            ? 'Total Registered Vehicles'
            : ($selectedTable === '16.2'
                ? 'Total Deposits (Billion Pesos)'
                : 'Total Banking Income (Billion Pesos)');
        $trendUnitLabel = $selectedTable === '13.1' ? 'Units' : 'Billion Pesos';
        $trendLabels = $years;
        $trendValues = [];
        $provinceHasData = true;
        $summaryLabel = 'Vehicles Total';
        $summaryDecimals = 0;
        $selectedDataType = null;

        if ($selectedTable === '13.1') {
            $totalRecords = (float) $this->resolveVehicleTotal($region->id, $selectedProvinceId, $selectedYear, $provinces);
            if ($selectedProvinceId) {
                $provinceHasData = VehicleRegistration::where('region_id', $region->id)
                    ->where('province_id', $selectedProvinceId)
                    ->where('year', $selectedYear)
                    ->exists();
            }
            foreach ($years as $year) {
                $trendValues[] = (float) $this->resolveVehicleTotal($region->id, $selectedProvinceId, $year, $provinces);
            }
        } else {
            $selectedDataType = $selectedTable === '16.2' ? 'banking_liabilities' : 'operating_income';
            $summaryLabel = $selectedTable === '16.2' ? 'Banking Total (B)' : 'Operating Income (B)';
            $summaryDecimals = 1;
            $totalRecords = (float) $this->resolveEconomicTotal($region->id, $selectedProvinceId, $selectedYear, $provinces, $selectedDataType);
            if ($selectedProvinceId) {
                $provinceHasData = EconomicData::where('region_id', $region->id)
                    ->where('province_id', $selectedProvinceId)
                    ->where('year', $selectedYear)
                    ->where('data_type', $selectedDataType)
                    ->exists();
            }
            foreach ($years as $year) {
                $trendValues[] = (float) $this->resolveEconomicTotal($region->id, $selectedProvinceId, $year, $provinces, $selectedDataType);
            }
        }

        $provinceDataStatus = $provinceHasData ? null : 'Data not yet available';

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
            ->whereIn('data_type', ['banking', 'banking_liabilities'])
            ->where('year', 2020)
            ->first();

        // Get latest vehicle registration data (2022); if user selected a province, scope to that province.
        $latestVehicleQuery = VehicleRegistration::where('region_id', $region->id)
            ->where('year', 2022);
        if ($selectedProvinceId) {
            $latestVehicleQuery->where('province_id', $selectedProvinceId);
            $latestVehicleData = $latestVehicleQuery->first();
        } else {
            $regionTotal = $latestVehicleQuery->whereNull('province_id')->first();
            $latestVehicleData = $regionTotal ?: VehicleRegistration::where('region_id', $region->id)
                ->where('year', 2022)
                ->whereNotNull('province_id')
                ->selectRaw('SUM(`private`) as `private`, SUM(private_vehicles) as private_vehicles, SUM(for_hire) as for_hire, SUM(government) as government, SUM(diplomatic) as diplomatic, SUM(exempt) as exempt, SUM(total) as total')
                ->first();
        }

        // Get latest operating income (2019)
        $latestIncomeData = EconomicData::where('region_id', $region->id)
            ->whereIn('data_type', ['income', 'operating_income'])
            ->where('year', 2019)
            ->first();

        // Banking trend data (2011-2020)
        $bankingTrend = EconomicData::where('region_id', $region->id)
            ->whereIn('data_type', ['banking', 'banking_liabilities'])
            ->whereBetween('year', [2011, 2020])
            ->orderBy('year')
            ->get();

        // Operating income trend data (2010-2019)
        $incomeTrend = EconomicData::where('region_id', $region->id)
            ->whereIn('data_type', ['income', 'operating_income'])
            ->whereBetween('year', [2010, 2019])
            ->orderBy('year')
            ->get();

        // Vehicle registration by province (2022); if a province is selected, show only that province's data.
        $vehicleByProvinceQuery = VehicleRegistration::where('region_id', $region->id)
            ->whereNotNull('province_id')
            ->where('year', $selectedYear)
            ->with('province');
        if ($selectedProvinceId) {
            $vehicleByProvinceQuery->where('province_id', $selectedProvinceId);
        }
        $vehicleByProvince = $vehicleByProvinceQuery->get()->keyBy(fn ($row) => $row->province?->name);

        $vehicleChartLabels = collect();
        $vehicleChartPrivate = collect();
        $vehicleChartForHire = collect();

        foreach ($provinces as $province) {
            $row = $vehicleByProvince->get($province->name);
            $vehicleChartLabels->push($province->name);
            $vehicleChartPrivate->push((int) ($row?->private ?? $row?->private_vehicles ?? 0));
            $vehicleChartForHire->push((int) ($row?->for_hire ?? 0));
        }

        $vehicleMix = [
            'private' => 0,
            'for_hire' => 0,
            'government' => 0,
        ];
        $vehicleMixQuery = VehicleRegistration::where('region_id', $region->id)
            ->where('year', $selectedYear);
        if ($selectedProvinceId) {
            $vehicleMixQuery->where('province_id', $selectedProvinceId);
            $mixRow = $vehicleMixQuery->first();
            if ($mixRow) {
                $vehicleMix = [
                    'private' => (int) ($mixRow->private ?? $mixRow->private_vehicles ?? 0),
                    'for_hire' => (int) ($mixRow->for_hire ?? 0),
                    'government' => (int) ($mixRow->government ?? 0),
                ];
            }
        } else {
            $regionMixRow = $vehicleMixQuery->whereNull('province_id')->first();
            if ($regionMixRow) {
                $vehicleMix = [
                    'private' => (int) ($regionMixRow->private ?? $regionMixRow->private_vehicles ?? 0),
                    'for_hire' => (int) ($regionMixRow->for_hire ?? 0),
                    'government' => (int) ($regionMixRow->government ?? 0),
                ];
            } else {
                $mixTotals = VehicleRegistration::where('region_id', $region->id)
                    ->where('year', $selectedYear)
                    ->whereIn('province_id', $provinces->pluck('id'))
                    ->selectRaw('SUM(`private`) as `private`, SUM(private_vehicles) as private_vehicles, SUM(for_hire) as for_hire, SUM(government) as government')
                    ->first();
                if ($mixTotals) {
                    $vehicleMix = [
                        'private' => (int) ($mixTotals->private ?? $mixTotals->private_vehicles ?? 0),
                        'for_hire' => (int) ($mixTotals->for_hire ?? 0),
                        'government' => (int) ($mixTotals->government ?? 0),
                    ];
                }
            }
        }

        if ($selectedTable === '13.1') {
            $provinceSummaries = $provinces->map(function ($province) use ($vehicleByProvince) {
                $row = $vehicleByProvince->get($province->name);
                return [
                    'province' => $province->name,
                    'province_id' => $province->id,
                    'total' => $row?->total !== null ? (int) $row->total : null,
                    'status' => $row ? 'Updated' : 'Pending Data',
                ];
            });
        } else {
            $economicByProvince = EconomicData::where('region_id', $region->id)
                ->whereNotNull('province_id')
                ->where('year', $selectedYear)
                ->where('data_type', $selectedDataType)
                ->get()
                ->keyBy(fn ($row) => $row->province?->name);
            $provinceSummaries = $provinces->map(function ($province) use ($economicByProvince) {
                $row = $economicByProvince->get($province->name);
                $value = $row?->total ?? ($row?->banking_liabilities ?? $row?->operating_income);
                return [
                    'province' => $province->name,
                    'province_id' => $province->id,
                    'total' => $value !== null ? (float) $value : null,
                    'status' => $row ? 'Updated' : 'Pending Data',
                ];
            });
        }

        $bankingDistributionSource = EconomicData::where('region_id', $region->id)
            ->whereIn('data_type', ['banking', 'banking_liabilities'])
            ->where('year', $selectedYear)
            ->first();

        // Banking institutions distribution (selected year)
        $bankingDistribution = [
            'Universal/Commercial Banks' => $bankingDistributionSource?->universal_commercial_banks
                ?? $bankingDistributionSource?->universal_banks
                ?? 0,
            'Thrift Banks' => $bankingDistributionSource?->thrift_banks ?? 0,
            'Rural/Cooperative Banks' => $bankingDistributionSource?->rural_cooperative_banks
                ?? $bankingDistributionSource?->rural_banks
                ?? 0,
        ];

        $fallbackBankingTotal = 807.1;
        $fallbackOperatingTotal = 16.3;
        $fallbackVehicleTotal = 1400000;
        $fallbackBankingBreakdown = [
            'universal' => 714.6,
            'thrift' => 57.3,
            'rural' => 35.3,
        ];

        $bankingTotalValue = $latestBankingData?->total ?? $latestBankingData?->banking_liabilities;
        if ($bankingTotalValue === null || (float) $bankingTotalValue === 0.0) {
            $bankingTotalValue = $fallbackBankingTotal;
        }

        $operatingTotalValue = $latestIncomeData?->total ?? $latestIncomeData?->operating_income;
        if ($operatingTotalValue === null || (float) $operatingTotalValue === 0.0) {
            $operatingTotalValue = $fallbackOperatingTotal;
        }

        $vehicleTotalValue = $latestVehicleData?->total;
        if ($vehicleTotalValue === null || (float) $vehicleTotalValue === 0.0) {
            $vehicleTotalValue = $fallbackVehicleTotal;
        }

        $universalValue = $latestBankingData?->universal_commercial_banks ?? $latestBankingData?->universal_banks;
        if ($universalValue === null || (float) $universalValue === 0.0) {
            $universalValue = $fallbackBankingBreakdown['universal'];
        }

        $thriftValue = $latestBankingData?->thrift_banks;
        if ($thriftValue === null || (float) $thriftValue === 0.0) {
            $thriftValue = $fallbackBankingBreakdown['thrift'];
        }

        $ruralValue = $latestBankingData?->rural_cooperative_banks ?? $latestBankingData?->rural_banks;
        if ($ruralValue === null || (float) $ruralValue === 0.0) {
            $ruralValue = $fallbackBankingBreakdown['rural'];
        }

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
                'value' => "\u{20B1}" . number_format($bankingTotalValue, 1) . 'B',
                'icon' => 'fa-bank',
                'trend' => '+18.5%',
                'subtitle' => '2020 Data',
            ],
            [
                'label' => 'Motor Vehicles Registered',
                'value' => $this->formatVehicleCount($vehicleTotalValue),
                'icon' => 'fa-car',
                'trend' => '+3.7%',
                'subtitle' => '2022 Data',
            ],
            [
                'label' => 'Operating Income',
                'value' => "\u{20B1}" . number_format($operatingTotalValue, 1) . 'B',
                'icon' => 'fa-chart-line',
                'trend' => '+0.6%',
                'subtitle' => '2019 Data',
            ],
            [
                'label' => 'Universal Banks',
                'value' => number_format($universalValue, 1),
                'icon' => 'fa-building',
                'trend' => '+6.9%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Thrift Banks',
                'value' => number_format($thriftValue, 1),
                'icon' => 'fa-piggy-bank',
                'trend' => '-7.7%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Rural Banks',
                'value' => number_format($ruralValue, 1),
                'icon' => 'fa-leaf',
                'trend' => '+12.7%',
                'subtitle' => 'Billion Pesos',
            ],
            [
                'label' => 'Private Vehicles',
                'value' => $this->formatVehicleCount($latestVehicleData?->private ?? $latestVehicleData?->private_vehicles),
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
            'vehicleMix',
            'bankingDistribution',
            'latestBankingData',
            'latestVehicleData',
            'latestIncomeData',
            'provinces',
            'provinceSummaries',
            'selectedProvinceId',
            'provinceDataStatus',
            'years',
            'selectedYear',
            'selectedTable',
            'summaryLabel',
            'summaryDecimals',
            'selectedDataType',
            'trendLabels',
            'trendValues',
            'trendUnitLabel'
        ));
    }

    private function resolveVehicleTotal(int $regionId, ?int $provinceId, int $year, $provinces): float
    {
        if ($provinceId) {
            $row = VehicleRegistration::where('region_id', $regionId)
                ->where('province_id', $provinceId)
                ->where('year', $year)
                ->first();
            return (float) ($row?->total ?? 0);
        }

        $regionRow = VehicleRegistration::where('region_id', $regionId)
            ->whereNull('province_id')
            ->where('year', $year)
            ->first();
        if ($regionRow && $regionRow->total !== null) {
            return (float) $regionRow->total;
        }

        return (float) VehicleRegistration::where('region_id', $regionId)
            ->whereIn('province_id', $provinces->pluck('id'))
            ->where('year', $year)
            ->sum('total');
    }

    private function resolveEconomicTotal(int $regionId, ?int $provinceId, int $year, $provinces, string $dataType): float
    {
        $valueColumn = $dataType === 'banking_liabilities' ? 'banking_liabilities' : 'operating_income';

        if ($provinceId) {
            $row = EconomicData::where('region_id', $regionId)
                ->where('province_id', $provinceId)
                ->where('year', $year)
                ->where('data_type', $dataType)
                ->first();
            return (float) ($row?->total ?? $row?->{$valueColumn} ?? 0);
        }

        $regionRow = EconomicData::where('region_id', $regionId)
            ->whereNull('province_id')
            ->where('year', $year)
            ->where('data_type', $dataType)
            ->first();
        if ($regionRow && ($regionRow->total !== null || $regionRow->{$valueColumn} !== null)) {
            return (float) ($regionRow->total ?? $regionRow->{$valueColumn} ?? 0);
        }

        $sumTotal = (float) EconomicData::where('region_id', $regionId)
            ->whereIn('province_id', $provinces->pluck('id'))
            ->where('year', $year)
            ->where('data_type', $dataType)
            ->sum('total');

        if ($sumTotal > 0) {
            return $sumTotal;
        }

        return (float) EconomicData::where('region_id', $regionId)
            ->whereIn('province_id', $provinces->pluck('id'))
            ->where('year', $year)
            ->where('data_type', $dataType)
            ->sum($valueColumn);
    }

    public function storeVehicleData(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, '403 Unauthorized: You can only modify data within your assigned province.');
        }

        $validated = $request->validate([
            'province_id' => ['required', 'exists:provinces,id'],
            'year' => ['required', 'integer', 'min:2010', 'max:2100'],
            'private' => ['required', 'integer', 'min:0'],
            'for_hire' => ['required', 'integer', 'min:0'],
            'government' => ['required', 'integer', 'min:0'],
            'diplomatic' => ['required', 'integer', 'min:0'],
            'exempt' => ['required', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
        ]);

        $region = Region::firstOrCreate(['code' => 'R3'], ['name' => 'Region III']);

        VehicleRegistration::withTrashed()->updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => (int) $validated['province_id'],
                'year' => (int) $validated['year'],
            ],
            [
                'classification' => 'total',
                'private' => $validated['private'],
                'private_vehicles' => $validated['private'],
                'for_hire' => $validated['for_hire'],
                'government' => $validated['government'],
                'diplomatic' => $validated['diplomatic'],
                'exempt' => $validated['exempt'],
                'total' => $validated['total'],
            ]
        );

        return redirect()->route('dashboard', [
            'province_id' => $validated['province_id'],
            'table' => '13.1',
            'year' => $validated['year'],
        ])->with('success', 'Vehicle data saved.');
    }

    public function storeBankingData(Request $request)
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, '403 Unauthorized: You can only modify data within your assigned province.');
        }

        $validated = $request->validate([
            'province_id' => ['required', 'exists:provinces,id'],
            'year' => ['required', 'integer', 'min:2010', 'max:2100'],
            'data_type' => ['required', 'in:banking_liabilities,operating_income'],
            'universal_commercial_banks' => ['required', 'numeric', 'min:0'],
            'thrift_banks' => ['required', 'numeric', 'min:0'],
            'rural_cooperative_banks' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
        ]);

        $region = Region::firstOrCreate(['code' => 'R3'], ['name' => 'Region III']);

        EconomicData::withTrashed()->updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => (int) $validated['province_id'],
                'year' => (int) $validated['year'],
                'data_type' => $validated['data_type'],
            ],
            [
                'total' => $validated['total'],
                'banking_liabilities' => $validated['data_type'] === 'banking_liabilities' ? $validated['total'] : null,
                'operating_income' => $validated['data_type'] === 'operating_income' ? $validated['total'] : null,
                'universal_commercial_banks' => $validated['universal_commercial_banks'],
                'thrift_banks' => $validated['thrift_banks'],
                'rural_cooperative_banks' => $validated['rural_cooperative_banks'],
                'universal_banks' => $validated['universal_commercial_banks'],
                'rural_banks' => $validated['rural_cooperative_banks'],
            ]
        );

        return redirect()->route('dashboard', [
            'province_id' => $validated['province_id'],
            'table' => $validated['data_type'] === 'banking_liabilities' ? '16.2' : '16.3',
            'year' => $validated['year'],
        ])->with('success', 'Banking data saved.');
    }
}
