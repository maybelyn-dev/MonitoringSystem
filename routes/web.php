<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RegionalStatisticsController;

// Landing/Home Route
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/access', function () {
    return view('pages.access-request');
})->name('access.request');

Route::get('/stats', [RegionalStatisticsController::class, 'publicIndex'])->name('stats.public');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/province/select', [DashboardController::class, 'selectProvince'])->name('province.select');

    // Regional Statistics Dashboard
    Route::get('/regional-statistics', [RegionalStatisticsController::class, 'index'])->name('regional-statistics');

    // Projects Routes
    Route::resource('projects', ProjectController::class);

    // Reports Route
    Route::get('/reports', [ReportsController::class, 'edit'])->name('reports');
    Route::put('/reports', [ReportsController::class, 'update'])->name('reports.update');

    // Settings Route
    Route::get('/settings', function () {
        return view('pages.dashboard');
    })->name('settings');
});

// Agencies Route (uses existing controller)
Route::resource('agencies', AgencyController::class);
