<?php

namespace App\Http\Controllers;

use App\Models\EconomicData;
use App\Models\Region;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function edit()
    {
        $region = Region::where('code', 'R3')->firstOrFail();

        $banking2020 = EconomicData::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('data_type', 'banking')
            ->where('year', 2020)
            ->first();

        $income2019 = EconomicData::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('data_type', 'income')
            ->where('year', 2019)
            ->first();

        $vehicles2022 = VehicleRegistration::where('region_id', $region->id)
            ->whereNull('province_id')
            ->where('year', 2022)
            ->first();

        return view('pages.reports.edit', compact('region', 'banking2020', 'income2019', 'vehicles2022'));
    }

    public function update(Request $request)
    {
        $region = Region::where('code', 'R3')->firstOrFail();

        $validated = $request->validate([
            'total_liabilities' => ['required', 'numeric', 'min:0'],
            'operating_income' => ['required', 'numeric', 'min:0'],
            'private_vehicles' => ['required', 'integer', 'min:0'],
            'gov_t_vehicles' => ['required', 'integer', 'min:0'],
            'for_hire' => ['required', 'integer', 'min:0'],
            'total_vehicles' => ['required', 'integer', 'min:0'],
        ]);

        EconomicData::updateOrCreate(
            [
                'region_id' => $region->id,
                'province_id' => null,
                'year' => 2020,
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
                'year' => 2019,
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
                'year' => 2022,
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

