<?php

namespace App\Http\Controllers;

use App\Models\EconomicData;
use App\Models\Project;
use App\Models\User;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $archivedProjects = Project::onlyTrashed()->with('agency')->orderByDesc('deleted_at')->get();
        $archivedUsers = User::onlyTrashed()->orderByDesc('deleted_at')->get();
        $archivedBanking = EconomicData::onlyTrashed()
            ->whereIn('data_type', ['banking', 'banking_liabilities', 'operating_income', 'income'])
            ->orderByDesc('deleted_at')
            ->get();
        $archivedVehicles = VehicleRegistration::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('pages.admin.archive', compact(
            'archivedProjects',
            'archivedUsers',
            'archivedBanking',
            'archivedVehicles'
        ));
    }

    public function restoreProject(Project $project)
    {
        $project->restore();
        return redirect()->route('admin.archive')->with('success', 'Project restored.');
    }

    public function restoreUser(User $user)
    {
        $user->restore();
        return redirect()->route('admin.archive')->with('success', 'User restored.');
    }

    public function restoreBanking(EconomicData $economicData)
    {
        $economicData->restore();
        return redirect()->route('admin.archive')->with('success', 'Banking record restored.');
    }

    public function restoreVehicle(VehicleRegistration $vehicleRegistration)
    {
        $vehicleRegistration->restore();
        return redirect()->route('admin.archive')->with('success', 'Vehicle record restored.');
    }
}
