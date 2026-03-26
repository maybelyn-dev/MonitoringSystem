<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('pages.admin.users', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,focal,focal_viewer'],
            'agency_name' => ['nullable', 'in:DICT,PSA'],
        ]);

        if ($validated['role'] === User::ROLE_FOCAL && empty($validated['agency_name'])) {
            return back()->withErrors(['agency_name' => 'Agency is required for Focal users.']);
        }

        $user->role = $validated['role'];

        if ($validated['role'] === User::ROLE_FOCAL) {
            $user->agency_name = $validated['agency_name'];
            $user->agency_id = $this->resolveAgencyId($validated['agency_name']);
        } else {
            $user->agency_name = null;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User archived.');
    }

    private function resolveAgencyId(string $agencyName): ?int
    {
        $defaults = [
            'DICT' => [
                'agency_name' => 'DICT Region III',
                'province' => 'Bulacan',
                'address' => 'DICT Region III',
                'contact' => 'N/A',
            ],
            'PSA' => [
                'agency_name' => 'PSA Region III',
                'province' => 'Bulacan',
                'address' => 'PSA Region III',
                'contact' => 'N/A',
            ],
        ];

        $agency = Agency::where('agency_name', 'like', $agencyName . '%')->orderBy('id')->first();
        if ($agency) {
            return $agency->id;
        }

        if (isset($defaults[$agencyName])) {
            $agency = Agency::create($defaults[$agencyName]);
            return $agency->id;
        }

        return null;
    }
}
