<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Statistic;
use Illuminate\Http\Request;

class RegionalStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $selectedInput = $request->get('province') ?: 'Bulacan';
        $selectedTable = $request->get('table') ?: '13.1';
        $years = range(2010, 2022);
        $allowedTables = ['13.1', '16.2', '16.3'];
        if (!in_array($selectedTable, $allowedTables, true)) {
            $selectedTable = '13.1';
        }

        $province = is_numeric($selectedInput)
            ? Province::find($selectedInput)
            : Province::where('name', $selectedInput)->first();

        $defaultYear = 2022;
        if ($selectedTable === '16.2') {
            $defaultYear = 2020;
        } elseif ($selectedTable === '16.3') {
            $defaultYear = 2019;
        }
        $requestedYear = $request->get('year');
        $selectedYear = in_array((int) $requestedYear, $years, true)
            ? (int) $requestedYear
            : $defaultYear;

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
        $latestVehicleYear = $selectedTable === '13.1' ? $selectedYear : null;
        $latestBankingYear = in_array($selectedTable, ['16.2', '16.3'], true) ? $selectedYear : null;
        $bankingTotalValue = $selectedTable === '13.1' ? null : $totalRecordsValue;

        return view('pages.regional-statistics', [
            'stats' => $stats,
            'selectedProvince' => $province?->name ?? $selectedInput,
            'selectedTable' => $selectedTable,
            'totalRecordsLabel' => $totalRecordsLabel,
            'totalRecordsValue' => $selectedTable === '13.1'
                ? number_format($totalRecordsValue, 0)
                : number_format($totalRecordsValue, 1),
            'latestVehicleYear' => $latestVehicleYear,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'privateValue' => $privateValue,
            'forHireValue' => $forHireValue,
            'governmentValue' => $governmentValue,
            'latestBankingYear' => $latestBankingYear,
            'bankingTotalValue' => $bankingTotalValue,
            'isEmpty' => $stats->isEmpty(),
            'years' => $years,
            'selectedYear' => $selectedYear,
        ]);
    }
}
