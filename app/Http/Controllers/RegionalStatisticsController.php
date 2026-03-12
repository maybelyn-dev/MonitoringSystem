<?php

namespace App\Http\Controllers;

use App\Models\RegionalStatistic;
use Illuminate\Support\Facades\Auth;

class RegionalStatisticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $selectedProvince = $user?->province?->name;

        $stats = RegionalStatistic::query()
            ->when($selectedProvince, fn ($q) => $q->where('province', $selectedProvince))
            ->orderBy('year')
            ->orderBy('category')
            ->orderBy('sub_category')
            ->get();

        $vehicleStats = $stats->where('category', 'Vehicles');
        $latestVehicleYear = $vehicleStats->max('year');
        $vehicleLatestRows = $latestVehicleYear
            ? $vehicleStats->where('year', $latestVehicleYear)
            : collect();

        $vehicleChartRows = $vehicleLatestRows->whereIn('sub_category', ['Private', 'For Hire', 'Government', 'Diplomatic', 'Exempt'])->values();
        $chartLabels = collect(['Private', 'For Hire', 'Government', 'Diplomatic', 'Exempt']);
        $chartValues = $chartLabels->map(function ($label) use ($vehicleChartRows) {
            return (float) optional($vehicleChartRows->firstWhere('sub_category', $label))->value ?? 0;
        })->values();
        $privateValue = (float) optional($vehicleChartRows->firstWhere('sub_category', 'Private'))->value ?? 0;
        $forHireValue = (float) optional($vehicleChartRows->firstWhere('sub_category', 'For Hire'))->value ?? 0;
        $governmentValue = (float) optional($vehicleChartRows->firstWhere('sub_category', 'Government'))->value ?? 0;

        $bankingRows = RegionalStatistic::query()
            ->where('province', 'Region III')
            ->where('category', 'Banking Liabilities')
            ->get();
        $latestBankingYear = $bankingRows->max('year');
        $bankingLatestRows = $latestBankingYear
            ? $bankingRows->where('year', $latestBankingYear)
            : collect();
        $bankingTotalValue = optional($bankingLatestRows->firstWhere('sub_category', 'Region III Total'))->value;

        return view('pages.regional-statistics', [
            'stats' => $stats,
            'selectedProvince' => $selectedProvince,
            'latestVehicleYear' => $latestVehicleYear,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'privateValue' => $privateValue,
            'forHireValue' => $forHireValue,
            'governmentValue' => $governmentValue,
            'latestBankingYear' => $latestBankingYear,
            'bankingTotalValue' => $bankingTotalValue,
            'isEmpty' => $stats->isEmpty(),
        ]);
    }
}
