<?php

namespace App\Http\Controllers;

use App\Models\User;
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
<<<<<<< HEAD
        return view('auth.login');
=======
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
            ->whereHas('region', function ($query) {
                $query->where('name', 'Region III');
            })
            ->orderBy('name', 'asc')
            ->get();
        return view('auth.login', compact('provinces'));
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }

<<<<<<< HEAD
        return back()->withErrors(['email' => 'Invalid credentials.']);
=======
        return back()->withErrors(['email' => 'Invalid credentials for this province.']);
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
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
            ->whereHas('region', function ($query) {
                $query->where('name', 'Region III');
            })
            ->orderBy('name', 'asc')
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
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
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
