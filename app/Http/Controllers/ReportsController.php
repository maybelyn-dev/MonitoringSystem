<?php

namespace App\Http\Controllers;

use App\Models\EconomicData;
use App\Models\Province;
use App\Models\Region;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function edit(Request $request)
    {
        $bankingYear = (int) $request->input('banking_year', 2020);
        $incomeYear = (int) $request->input('income_year', 2019);
        $vehiclesYear = (int) $request->input('vehicles_year', 2022);
        $summaryYear = 2018;

        if (!Auth::user()?->isSuperAdmin()) {
            abort(403, 'Only Super Admin can edit regional reports.');
        }

        $region = Region::where('code', 'R3')->firstOrFail();
        $provinces = Province::where('region_id', $region->id)
            ->orderBy('name')
            ->get();

        $provinceId = $request->input('province_id');
        $province = $provinceId
            ? $provinces->firstWhere('id', (int) $provinceId)
            : $provinces->first();

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

        $summaryRow = $province
            ? VehicleRegistration::where('region_id', $region->id)
                ->where('province_id', $province->id)
                ->where('year', $summaryYear)
                ->first()
            : null;

        $summary = [
            'Private' => (int) ($summaryRow?->private_vehicles ?? 0),
            'For Hire' => (int) ($summaryRow?->for_hire ?? 0),
            'Government' => (int) ($summaryRow?->government ?? 0),
        ];

        return view('pages.reports.edit', compact(
            'region',
            'banking2020',
            'income2019',
            'vehicles2022',
            'bankingYear',
            'incomeYear',
            'vehiclesYear',
            'provinces',
            'province',
            'summary'
        ));
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
}
