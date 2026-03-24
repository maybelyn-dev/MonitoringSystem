<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RegionalStatisticsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProjectImportController;
use App\Http\Controllers\RegionDataImportController;
use App\Http\Controllers\ArchiveController;

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
    Route::post('/dashboard/vehicles', [DashboardController::class, 'storeVehicleData'])->name('dashboard.vehicles.store')->middleware('role:admin');
    Route::post('/dashboard/banking', [DashboardController::class, 'storeBankingData'])->name('dashboard.banking.store')->middleware('role:admin');

    // Regional Statistics Dashboard
    Route::get('/regional-statistics', [RegionalStatisticsController::class, 'index'])->name('regional-statistics');

    // Projects Routes
    Route::resource('projects', ProjectController::class)->only(['index']);
    Route::resource('projects', ProjectController::class)->except(['index'])->middleware('role:admin,focal');

    // Reports Route
    Route::get('/reports', [ReportsController::class, 'edit'])->name('reports');
    Route::put('/reports', [ReportsController::class, 'update'])->name('reports.update')->middleware('role:admin,focal');

    // Project Imports
    Route::middleware('role:admin,focal')->group(function () {
        Route::get('/imports/projects', [ProjectImportController::class, 'showUpload'])->name('imports.projects');
        Route::post('/imports/projects/upload', [ProjectImportController::class, 'handleUpload'])->name('imports.projects.upload');
        Route::get('/imports/projects/mapping', [ProjectImportController::class, 'showMapping'])->name('imports.projects.mapping');
        Route::post('/imports/projects/import', [ProjectImportController::class, 'import'])->name('imports.projects.import');

        Route::get('/imports/region-data', [RegionDataImportController::class, 'showUpload'])->name('imports.region-data');
        Route::post('/imports/region-data/upload', [RegionDataImportController::class, 'handleUpload'])->name('imports.region-data.upload');
        Route::get('/imports/region-data/mapping', [RegionDataImportController::class, 'showMapping'])->name('imports.region-data.mapping');
        Route::post('/imports/region-data/import', [RegionDataImportController::class, 'import'])->name('imports.region-data.import');
    });

    // Settings Route
    Route::get('/settings', function () {
        return view('pages.dashboard');
    })->name('settings');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/archive', [ArchiveController::class, 'index'])->name('admin.archive');
    Route::post('/admin/archive/projects/{project}/restore', [ArchiveController::class, 'restoreProject'])->name('admin.archive.projects.restore')->withTrashed();
    Route::post('/admin/archive/users/{user}/restore', [ArchiveController::class, 'restoreUser'])->name('admin.archive.users.restore')->withTrashed();
    Route::post('/admin/archive/banking/{economicData}/restore', [ArchiveController::class, 'restoreBanking'])->name('admin.archive.banking.restore')->withTrashed();
    Route::post('/admin/archive/vehicles/{vehicleRegistration}/restore', [ArchiveController::class, 'restoreVehicle'])->name('admin.archive.vehicles.restore')->withTrashed();
});

// Agencies Route (uses existing controller)
Route::resource('agencies', AgencyController::class)->middleware(['auth', 'role:admin']);
