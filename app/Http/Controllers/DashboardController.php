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

    public function index(Request $request)
    {
        $region = Region::where('code', 'R3')->first();
        $userProvinceId = $this->resolveSelectedProvinceId($request);
        $selectedYear = $this->resolveSelectedYear($request);

        if (!$region) {
            return view('pages.dashboard', [
                'metrics' => [],
                'bankingTrend' => collect(),
                'incomeTrend' => collect(),
                'vehicleByProvince' => collect(),
                'vehicleChartLabels' => collect(),
                'vehicleChartPrivate' => collect(),
                'vehicleChartForHire' => collect(),
                'bankingDistribution' => [],
                'latestBankingData' => null,
                'latestVehicleData' => null,
                'latestIncomeData' => null,
            ]);
        }

        $latestBankingData = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'banking')
            ->where('year', $selectedYear)
            ->first();

        $latestVehicleQuery = VehicleRegistration::where('region_id', $region->id)
            ->where('year', $selectedYear);
        if ($userProvinceId) {
            $latestVehicleQuery->where('province_id', $userProvinceId);
        } else {
            $latestVehicleQuery->whereNull('province_id');
        }
        $latestVehicleData = $latestVehicleQuery->first();

        $latestIncomeData = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'income')
            ->where('year', $selectedYear)
            ->first();

        $bankingTrend = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'banking')
            ->where('year', $selectedYear)
            ->orderBy('year')
            ->get();

        $incomeTrend = EconomicData::where('region_id', $region->id)
            ->where('data_type', 'income')
            ->where('year', $selectedYear)
            ->orderBy('year')
            ->get();

        $vehicleByProvinceQuery = VehicleRegistration::where('region_id', $region->id)
            ->whereNotNull('province_id')
            ->where('year', $selectedYear)
            ->with('province');
        if ($userProvinceId) {
            $vehicleByProvinceQuery->where('province_id', $userProvinceId);
        }
        $vehicleByProvince = $vehicleByProvinceQuery->get();

        $vehicleChartLabels = $vehicleByProvince->map(fn ($row) => $row->province?->name)->filter()->values();
        $vehicleChartPrivate = $vehicleByProvince->map(fn ($row) => (int) $row->private_vehicles)->values();
        $vehicleChartForHire = $vehicleByProvince->map(fn ($row) => (int) $row->for_hire)->values();

        $bankingDistribution = [
            'Universal Banks' => $latestBankingData?->universal_banks ?? 0,
            'Thrift Banks' => $latestBankingData?->thrift_banks ?? 0,
            'Rural Banks' => $latestBankingData?->rural_banks ?? 0,
        ];

        $metrics = [
            [
                'label' => 'Total Banking Liabilities',
                'value' => "\u{20B1}" . number_format($latestBankingData?->banking_liabilities ?? 0, 1) . 'B',
                'icon' => 'fa-bank',
                'trend' => '+18.5%',
                'subtitle' => $selectedYear . ' Data',
            ],
            [
                'label' => 'Motor Vehicles Registered',
                'value' => $this->formatVehicleCount($latestVehicleData?->total),
                'icon' => 'fa-car',
                'trend' => '+3.7%',
                'subtitle' => $selectedYear . ' Data',
            ],
            [
                'label' => 'Operating Income',
                'value' => "\u{20B1}" . number_format($latestIncomeData?->operating_income ?? 0, 1) . 'B',
                'icon' => 'fa-chart-line',
                'trend' => '+0.6%',
                'subtitle' => $selectedYear . ' Data',
            ],
            [
                'label' => 'Universal Banks',
                'value' => number_format($latestBankingData?->universal_banks ?? 0, 1),
                'icon' => 'fa-building-columns',
                'trend' => '+6.9%',
                'subtitle' => 'Billion Pesos',
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

    public function selectProvince(Request $request)
    {
        $user = Auth::user();
        if ($request->input('province_id') === 'all') {
            $request->merge(['province_id' => null]);
        }
        $validated = $request->validate([
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'year' => ['nullable', 'integer', 'min:2020', 'max:2026'],
        ]);

        $provinceId = $validated['province_id'] ?? null;
        $year = $validated['year'] ?? null;

        if (!$user || !$user->isSuperAdmin()) {
            $provinceId = $provinceId ?: $user?->province_id;
        }

        $request->session()->put('province_id', $provinceId);
        if ($year) {
            $request->session()->put('year', $year);
        }

        return back();
    }

    private function resolveSelectedProvinceId(Request $request): ?int
    {
        $user = Auth::user();
        $region = Region::where('code', 'R3')->first();
        $provinceIds = $region
            ? Province::where('region_id', $region->id)->pluck('id')->all()
            : [];

        $selected = $request->input('province_id')
            ?? $request->session()->get('province_id')
            ?? $user?->province_id;

        if ($user && $user->isSuperAdmin()) {
            return $selected ? (int) $selected : null;
        }

        if (!$selected || !in_array((int) $selected, $provinceIds, true)) {
            if ($user?->province_id && in_array((int) $user->province_id, $provinceIds, true)) {
                return (int) $user->province_id;
            }

            return $provinceIds[0] ?? null;
        }

        return (int) $selected;
    }

    private function resolveSelectedYear(Request $request): int
    {
        $year = $request->input('year')
            ?? $request->session()->get('year')
            ?? 2026;

        $year = (int) $year;
        if ($year < 2020 || $year > 2026) {
            return 2026;
        }

        return $year;
    }
}
