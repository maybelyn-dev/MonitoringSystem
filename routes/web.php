<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RegionalStatisticsController;
use App\Http\Controllers\UserManagementController;

// Landing/Home Route
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

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

    // Regional Statistics Dashboard
    Route::get('/regional-statistics', [RegionalStatisticsController::class, 'index'])->name('regional-statistics');

    // Projects Routes
    Route::resource('projects', ProjectController::class)->only(['index']);
    Route::resource('projects', ProjectController::class)->except(['index'])->middleware('role:admin,focal');

    // Reports Route
    Route::get('/reports', [ReportsController::class, 'edit'])->name('reports');
    Route::put('/reports', [ReportsController::class, 'update'])->name('reports.update')->middleware('role:admin,focal');

    // Settings Route
    Route::get('/settings', function () {
        return view('pages.dashboard');
    })->name('settings');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
});

// Agencies Route (uses existing controller)
Route::resource('agencies', AgencyController::class)->middleware(['auth', 'role:admin']);
