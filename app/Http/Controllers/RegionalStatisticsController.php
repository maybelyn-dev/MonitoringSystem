<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\RegionalStatistic;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionalStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedProvince = $this->resolveSelectedProvinceName(
            $request,
            $user?->isSuperAdmin() ?? false,
            $user?->province_id
        );
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
