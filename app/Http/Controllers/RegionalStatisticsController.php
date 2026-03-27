<?php

namespace App\Http\Controllers;

use App\Models\Province;
<<<<<<< HEAD
use App\Models\RegionalStatistic;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\Statistic;
use Illuminate\Http\Request;
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c

class RegionalStatisticsController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        $user = Auth::user();
        $selectedProvince = $this->resolveSelectedProvinceName(
            $request,
            $user?->isSuperAdmin() ?? false,
            $user?->province_id
        );
        $selectedYear = $this->resolveSelectedYear($request);
=======
        $selectedInput = $request->get('province') ?: 'Bulacan';
        $selectedTable = $request->get('table') ?: '13.1';
        $allowedTables = ['13.1', '16.2', '16.3'];
        if (!in_array($selectedTable, $allowedTables, true)) {
            $selectedTable = '13.1';
        }
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c

        $province = is_numeric($selectedInput)
            ? Province::find($selectedInput)
            : Province::where('name', $selectedInput)->first();

<<<<<<< HEAD
        $vehicleStats = $stats->where('category', 'Vehicles');
        $vehicleLatestRows = $selectedYear
            ? $vehicleStats->where('year', $selectedYear)
            : collect();

        $chartLabels = collect(['Private', 'For Hire', 'Government', 'Diplomatic', 'Exempt']);
        if ($selectedProvince) {
            $vehicleChartRows = $vehicleLatestRows->whereIn('sub_category', $chartLabels)->values();
            $chartValues = $chartLabels->map(function ($label) use ($vehicleChartRows) {
                return (float) optional($vehicleChartRows->firstWhere('sub_category', $label))->value ?? 0;
            })->values();
        } else {
            $vehicleChartRows = $vehicleLatestRows->whereIn('sub_category', $chartLabels)
                ->groupBy('sub_category')
                ->map(fn ($rows) => (float) $rows->sum('value'));
            $chartValues = $chartLabels->map(fn ($label) => (float) ($vehicleChartRows[$label] ?? 0))->values();
        }

        $privateValue = (float) ($chartValues->get(0) ?? 0);
        $forHireValue = (float) ($chartValues->get(1) ?? 0);
        $governmentValue = (float) ($chartValues->get(2) ?? 0);

        $bankingRows = RegionalStatistic::query()
            ->where('province', 'Region III')
            ->where('category', 'Banking Liabilities')
            ->get();
        $bankingLatestRows = $selectedYear
            ? $bankingRows->where('year', $selectedYear)
            : collect();
        $bankingTotalValue = optional($bankingLatestRows->firstWhere('sub_category', 'Region III Total'))->value;

        return view('pages.regional-statistics', [
            'stats' => $stats,
            'selectedProvince' => $selectedProvince,
            'latestVehicleYear' => $selectedYear,
=======
        if (in_array($selectedTable, ['16.2', '16.3'], true)) {
            $province = Province::where('name', 'Region III Total')->first() ?? $province;
        }

        $selectedYear = 2018;
        if ($selectedTable === '16.2') {
            $selectedYear = 2020;
        } elseif ($selectedTable === '16.3') {
            $selectedYear = 2019;
        }

        $stats = $province
            ? Statistic::query()
                ->with('category')
                ->where('province_id', $province->id)
                ->where('year', $selectedYear)
                ->where('table_reference', $selectedTable)
                ->get()
            : collect();

        $chartLabelMap = $selectedTable === '13.1'
            ? collect([
                ['label' => 'Private', 'category' => 'Private'],
                ['label' => 'For Hire', 'category' => 'For Hire'],
                ['label' => 'Gov', 'category' => 'Government'],
            ])
            : collect([
                ['label' => 'Universal', 'category' => 'Universal and Commercial Banks'],
                ['label' => 'Thrift', 'category' => 'Thrift Banks'],
                ['label' => 'Rural', 'category' => 'Rural and Cooperative Banks'],
            ]);
        $chartLabels = $chartLabelMap->pluck('label');
        $chartValues = $chartLabelMap->map(function ($item) use ($stats) {
            $row = $stats->first(fn ($stat) => $stat->category?->name === $item['category']);
            return (float) ($row?->value ?? 0);
        })->values();

        $totalRow = $stats->first(fn ($stat) => $stat->category?->name === 'Total');
        $totalRecordsValue = $totalRow
            ? (float) $totalRow->value
            : (float) $chartValues->sum();
        $totalRecordsLabel = $selectedTable === '13.1'
            ? 'Total Registered Vehicles'
            : 'Total Banking Value (Billion Pesos)';

        if ($stats->isEmpty()) {
            $chartValues = collect([0, 0, 0]);
            $totalRecordsValue = 0.0;
        }

        $privateValue = (float) ($stats->first(fn ($stat) => $stat->category?->name === 'Private')?->value ?? 0);
        $forHireValue = (float) ($stats->first(fn ($stat) => $stat->category?->name === 'For Hire')?->value ?? 0);
        $governmentValue = (float) ($stats->first(fn ($stat) => $stat->category?->name === 'Government')?->value ?? 0);
        $latestVehicleYear = $stats->isEmpty() ? null : $selectedYear;
        $latestBankingYear = null;
        $bankingTotalValue = null;

        return view('pages.regional-statistics', [
            'stats' => $stats,
            'selectedProvince' => $province?->name ?? $selectedInput,
            'selectedTable' => $selectedTable,
            'totalRecordsLabel' => $totalRecordsLabel,
            'totalRecordsValue' => $selectedTable === '13.1'
                ? number_format($totalRecordsValue, 0)
                : number_format($totalRecordsValue, 1),
            'latestVehicleYear' => $latestVehicleYear,
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'privateValue' => $privateValue,
            'forHireValue' => $forHireValue,
            'governmentValue' => $governmentValue,
            'latestBankingYear' => $selectedYear,
            'bankingTotalValue' => $bankingTotalValue,
            'isEmpty' => $stats->isEmpty(),
            'isPublic' => false,
        ]);
    }

    public function publicIndex(Request $request)
    {
        $selectedProvince = $this->resolveSelectedProvinceName($request, true, null);
        $selectedYear = $this->resolveSelectedYear($request);

        $stats = RegionalStatistic::query()
            ->when($selectedProvince, fn ($q) => $q->where('province', $selectedProvince))
            ->orderBy('year')
            ->orderBy('category')
            ->orderBy('sub_category')
            ->get();

        $vehicleStats = $stats->where('category', 'Vehicles');
        $vehicleLatestRows = $selectedYear
            ? $vehicleStats->where('year', $selectedYear)
            : collect();

        $chartLabels = collect(['Private', 'For Hire', 'Government', 'Diplomatic', 'Exempt']);
        if ($selectedProvince) {
            $vehicleChartRows = $vehicleLatestRows->whereIn('sub_category', $chartLabels)->values();
            $chartValues = $chartLabels->map(function ($label) use ($vehicleChartRows) {
                return (float) optional($vehicleChartRows->firstWhere('sub_category', $label))->value ?? 0;
            })->values();
        } else {
            $vehicleChartRows = $vehicleLatestRows->whereIn('sub_category', $chartLabels)
                ->groupBy('sub_category')
                ->map(fn ($rows) => (float) $rows->sum('value'));
            $chartValues = $chartLabels->map(fn ($label) => (float) ($vehicleChartRows[$label] ?? 0))->values();
        }

        $privateValue = (float) ($chartValues->get(0) ?? 0);
        $forHireValue = (float) ($chartValues->get(1) ?? 0);
        $governmentValue = (float) ($chartValues->get(2) ?? 0);

        $bankingRows = RegionalStatistic::query()
            ->where('province', 'Region III')
            ->where('category', 'Banking Liabilities')
            ->get();
        $bankingLatestRows = $selectedYear
            ? $bankingRows->where('year', $selectedYear)
            : collect();
        $bankingTotalValue = optional($bankingLatestRows->firstWhere('sub_category', 'Region III Total'))->value;

        return view('pages.regional-statistics', [
            'stats' => $stats,
            'selectedProvince' => $selectedProvince,
            'latestVehicleYear' => $selectedYear,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'privateValue' => $privateValue,
            'forHireValue' => $forHireValue,
            'governmentValue' => $governmentValue,
            'latestBankingYear' => $selectedYear,
            'bankingTotalValue' => $bankingTotalValue,
            'isEmpty' => $stats->isEmpty(),
            'isPublic' => true,
        ]);
    }

    private function resolveSelectedProvinceName(Request $request, bool $allowGlobal, ?int $userProvinceId): ?string
    {
        $region = Region::where('code', 'R3')->first();
        $provinceQuery = $region
            ? Province::where('region_id', $region->id)->orderBy('name')
            : Province::query()->whereRaw('1=0');
        $provinces = $provinceQuery->get();

        $requestedId = $request->input('province_id');
        $sessionId = $request->session()->get('province_id');
        $selectedId = $requestedId ?? $sessionId ?? $userProvinceId;

        if ($selectedId && !$provinces->contains('id', (int) $selectedId)) {
            $selectedId = null;
        }

        if (!$selectedId && !$allowGlobal) {
            $selectedId = $provinces->contains('id', (int) $userProvinceId)
                ? (int) $userProvinceId
                : ($provinces->first()?->id);
        }

        $province = $selectedId ? $provinces->firstWhere('id', (int) $selectedId) : null;

        return $province?->name;
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
