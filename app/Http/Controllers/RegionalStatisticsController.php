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
        $selectedTable = $this->resolveSelectedTable($request);
        $selectedCategory = $this->mapTableToCategory($selectedTable);

        $selectedProvince = $this->resolveSelectedProvinceName(
            $request,
            $user?->isSuperAdmin() ?? false,
            $user?->province_id
        );

        if ($selectedTable !== '13.1') {
            $selectedProvince = 'Region III';
        }

        $selectedYear = $this->resolveSelectedYear($request);

        $stats = RegionalStatistic::query()
            ->when($selectedCategory, fn ($q) => $q->where('category', $selectedCategory))
            ->when($selectedProvince, fn ($q) => $q->where('province', $selectedProvince))
            ->orderBy('year')
            ->orderBy('category')
            ->orderBy('sub_category')
            ->get();

        $chartData = $this->buildChartData($stats, $selectedCategory, $selectedProvince, $selectedYear);
        $chartLabels = $chartData['labels'];
        $chartValues = $chartData['values'];
        $privateValue = $chartData['privateValue'];
        $forHireValue = $chartData['forHireValue'];
        $governmentValue = $chartData['governmentValue'];

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
            'selectedTable' => $selectedTable,
            'selectedProvinceId' => $this->resolveSelectedProvinceId($request, $user?->province_id),
        ]);
    }

    public function publicIndex(Request $request)
    {
        $selectedTable = $this->resolveSelectedTable($request);
        $selectedCategory = $this->mapTableToCategory($selectedTable);

        $selectedProvince = $this->resolveSelectedProvinceName($request, true, null);
        if ($selectedTable !== '13.1') {
            $selectedProvince = 'Region III';
        }
        $selectedYear = $this->resolveSelectedYear($request);

        $stats = RegionalStatistic::query()
            ->when($selectedCategory, fn ($q) => $q->where('category', $selectedCategory))
            ->when($selectedProvince, fn ($q) => $q->where('province', $selectedProvince))
            ->orderBy('year')
            ->orderBy('category')
            ->orderBy('sub_category')
            ->get();

        $chartData = $this->buildChartData($stats, $selectedCategory, $selectedProvince, $selectedYear);
        $chartLabels = $chartData['labels'];
        $chartValues = $chartData['values'];
        $privateValue = $chartData['privateValue'];
        $forHireValue = $chartData['forHireValue'];
        $governmentValue = $chartData['governmentValue'];

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
            'selectedTable' => $selectedTable,
            'selectedProvinceId' => $this->resolveSelectedProvinceId($request, null),
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

    private function resolveSelectedProvinceId(Request $request, ?int $userProvinceId): ?int
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
            return null;
        }

        return $selectedId ? (int) $selectedId : null;
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

    private function resolveSelectedTable(Request $request): string
    {
        $table = (string) $request->input('table', '13.1');
        $allowed = ['13.1', '16.2', '16.3'];

        return in_array($table, $allowed, true) ? $table : '13.1';
    }

    private function mapTableToCategory(string $table): string
    {
        return match ($table) {
            '16.2' => 'Banking Liabilities',
            '16.3' => 'Operating Income',
            default => 'Vehicles',
        };
    }

    private function buildChartData($stats, string $category, ?string $selectedProvince, int $selectedYear): array
    {
        $latestRows = $selectedYear
            ? $stats->where('year', $selectedYear)->where('category', $category)
            : collect();

        if ($category === 'Vehicles') {
            $chartLabels = collect(['Private', 'For Hire', 'Government', 'Diplomatic', 'Exempt']);
        } else {
            $chartLabels = collect([
                'Universal and Commercial Banks',
                'Thrift Banks',
                'Rural and Cooperative Banks',
                'Region III Total',
            ]);
        }

        if ($selectedProvince) {
            $chartRows = $latestRows->whereIn('sub_category', $chartLabels)->values();
            $chartValues = $chartLabels->map(function ($label) use ($chartRows) {
                return (float) optional($chartRows->firstWhere('sub_category', $label))->value ?? 0;
            })->values();
        } else {
            $chartRows = $latestRows->whereIn('sub_category', $chartLabels)
                ->groupBy('sub_category')
                ->map(fn ($rows) => (float) $rows->sum('value'));
            $chartValues = $chartLabels->map(fn ($label) => (float) ($chartRows[$label] ?? 0))->values();
        }

        return [
            'labels' => $chartLabels,
            'values' => $chartValues,
            'privateValue' => (float) ($chartValues->get(0) ?? 0),
            'forHireValue' => (float) ($chartValues->get(1) ?? 0),
            'governmentValue' => (float) ($chartValues->get(2) ?? 0),
        ];
    }
}
