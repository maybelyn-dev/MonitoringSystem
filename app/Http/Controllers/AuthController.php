<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
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

        $remember = (bool) $request->boolean('remember');
        try {
            if (Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Logged in successfully!');
            }
        } catch (\RuntimeException $e) {
            return back()->withErrors([
                'email' => 'Your password needs to be reset. Please contact the admin.',
            ]);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('landing')->with('success', 'Logged out successfully!');
    }
}
