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

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
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
