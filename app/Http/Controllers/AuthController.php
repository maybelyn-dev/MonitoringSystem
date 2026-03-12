<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agency;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        $provinces = Province::whereHas('region', fn ($q) => $q->where('code', 'R3'))
            ->orderBy('name')
            ->get();
        return view('auth.login', compact('provinces'));
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'province_id' => 'required|exists:provinces,id',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            // Persist province selection as the user's current monitoring scope.
            $user->province_id = (int) $validated['province_id'];
            if (!$user->agency_id) {
                $province = Province::find($validated['province_id']);
                $agency = Agency::where('province', $province?->name)->orderBy('id')->first();
                if (!$agency && $province) {
                    $agency = Agency::create([
                        'agency_name' => $province->name . ' - Region III Monitoring',
                        'province' => $province->name,
                        'address' => $province->name . ', Region III',
                        'contact' => 'N/A',
                    ]);
                }
                $user->agency_id = $agency?->id;
            }
            $user->save();

            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid credentials for this province.']);
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        $provinces = Province::whereHas('region', fn ($q) => $q->where('code', 'R3'))
            ->orderBy('name')
            ->get();
        return view('pages.auth.register', compact('provinces'));
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'province_id' => 'required|exists:provinces,id',
            'terms' => 'required|accepted',
        ], [
            'password.regex' => 'Password must contain uppercase, lowercase, and numbers.',
            'terms.required' => 'You must accept the terms and conditions.',
        ]);

        // Construct full name from first, middle initial, and last name
        $fullName = $validated['first_name'];
        if ($validated['middle_initial']) {
            $fullName .= ' ' . $validated['middle_initial'] . '.';
        }
        $fullName .= ' ' . $validated['last_name'];

        $user = User::create([
            'name' => trim($fullName),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'province_id' => (int) $validated['province_id'],
        ]);

        // Ensure an agency record exists for legacy project scoping.
        $province = Province::find($validated['province_id']);
        $agency = Agency::where('province', $province?->name)->orderBy('id')->first();
        if (!$agency && $province) {
            $agency = Agency::create([
                'agency_name' => $province->name . ' - Region III Monitoring',
                'province' => $province->name,
                'address' => $province->name . ', Region III',
                'contact' => 'N/A',
            ]);
        }
        if ($agency) {
            $user->agency_id = $agency->id;
            $user->save();
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing')->with('success', 'Logged out successfully!');
    }
}
