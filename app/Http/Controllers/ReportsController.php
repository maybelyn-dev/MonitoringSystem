<?php

namespace App\Http\Controllers;

use App\Models\EconomicData;
use App\Models\Province;
use App\Models\Region;
use App\Models\Statistic;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function edit(Request $request)
    {
        $bankingYear = (int) request('banking_year', 2020);
        $incomeYear = (int) request('income_year', 2019);
        $vehiclesYear = (int) request('vehicles_year', 2022);

        if (!Auth::user()?->isSuperAdmin()) {
            abort(403, 'Only Super Admin can edit regional reports.');
        }

        $region = Region::where('code', 'R3')->firstOrFail();
        $selectedProvinceId = $request->get('province_id') ?? $request->user()?->province_id;
        $province = $selectedProvinceId
            ? Province::find($selectedProvinceId)
            : Province::where('name', 'Bulacan')->first();

        $banking2020 = EconomicData::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('data_type', 'banking')
            ->where('year', $bankingYear)
            ->first();

        $income2019 = EconomicData::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('data_type', 'income')
            ->where('year', $incomeYear)
            ->first();

        $vehicles2022 = VehicleRegistration::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('year', $vehiclesYear)
            ->first();

<<<<<<< HEAD
        return view('pages.reports.edit', compact('region', 'banking2020', 'income2019', 'vehicles2022', 'bankingYear', 'incomeYear', 'vehiclesYear'));
=======
        $stats = $province
            ? Statistic::query()
                ->with('category')
                ->where('province_id', $province->id)
                ->where('year', 2018)
                ->where('table_reference', '13.1')
                ->get()
            : collect();

        $summary = [
            'Private' => (float) ($stats->first(fn ($row) => $row->category?->name === 'Private')?->value ?? 0),
            'For Hire' => (float) ($stats->first(fn ($row) => $row->category?->name === 'For Hire')?->value ?? 0),
            'Government' => (float) ($stats->first(fn ($row) => $row->category?->name === 'Government')?->value ?? 0),
        ];

        if ($request->get('export') === 'csv') {
            $lines = [
                'Province,Year,Table,Private,For Hire,Government',
                sprintf(
                    '%s,%d,%s,%s,%s,%s',
                    $province?->name ?? 'N/A',
                    2018,
                    '13.1',
                    $summary['Private'],
                    $summary['For Hire'],
                    $summary['Government']
                ),
            ];
            $csv = implode("\n", $lines);
            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="province-summary.csv"',
            ]);
        }

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
            ->whereHas('region', fn ($q) => $q->where('name', 'Region III'))
            ->orderBy('name')
            ->get();

        return view('pages.reports.edit', compact(
            'region',
            'banking2020',
            'income2019',
            'vehicles2022',
            'province',
            'provinces',
            'summary'
        ));
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
    }

    public function update(Request $request)
    {
        if (!Auth::user()?->isSuperAdmin()) {
            abort(403, 'Only Super Admin can update regional reports.');
        }

        $region = Region::where('code', 'R3')->firstOrFail();
        $bankingYear = (int) $request->input('banking_year', 2020);
        $incomeYear = (int) $request->input('income_year', 2019);
        $vehiclesYear = (int) $request->input('vehicles_year', 2022);

        $validated = $request->validate([
            'total_liabilities' => ['required', 'numeric', 'min:0'],
            'operating_income' => ['required', 'numeric', 'min:0'],
            'private_vehicles' => ['required', 'integer', 'min:0'],
            'gov_t_vehicles' => ['required', 'integer', 'min:0'],
            'for_hire' => ['required', 'integer', 'min:0'],
            'total_vehicles' => ['required', 'integer', 'min:0'],
            'banking_year' => ['required', 'integer', 'min:2011', 'max:2020'],
            'income_year' => ['required', 'integer', 'min:2010', 'max:2019'],
            'vehicles_year' => ['required', 'integer', 'min:2018', 'max:2022'],
        ]);

        EconomicData::updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => null,
                'year' => $bankingYear,
                'data_type' => 'banking',
            ],
            [
                'banking_liabilities' => $validated['total_liabilities'],
            ]
        );

        EconomicData::updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => null,
                'year' => $incomeYear,
                'data_type' => 'income',
            ],
            [
                'operating_income' => $validated['operating_income'],
            ]
        );

        VehicleRegistration::updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => null,
                'year' => $vehiclesYear,
            ],
            [
                'classification' => 'total',
                'private_vehicles' => $validated['private_vehicles'],
                'for_hire' => $validated['for_hire'],
                'government' => $validated['gov_t_vehicles'],
                'diplomatic' => 0,
                'exempt' => 78,
                'total' => $validated['total_vehicles'],
            ]
        );

        return redirect()->route('reports')->with('success', 'Region III stats updated.');
    }
<<<<<<< HEAD
=======

>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
}
