<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Region;
use App\Models\Province;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.navbar', function ($view) {
            if (!Auth::check()) {
                return;
            }

            $region = Region::where('code', 'R3')->first();
            $provinces = $region
                ? Province::where('region_id', $region->id)->orderBy('name')->get()
                : collect();

            $user = Auth::user();
            $sessionProvinceId = session('province_id');
            $sessionYear = session('year');
            $defaultProvinceId = $user?->province_id;
            $selectedProvinceId = $sessionProvinceId ?? $defaultProvinceId;

            if (!$user?->isSuperAdmin()) {
                if (!$selectedProvinceId || !$provinces->contains('id', (int) $selectedProvinceId)) {
                    $selectedProvinceId = $provinces->contains('id', (int) $defaultProvinceId)
                        ? (int) $defaultProvinceId
                        : ($provinces->first()?->id);
                }
            } else {
                $selectedProvinceId = $sessionProvinceId ? (int) $sessionProvinceId : null;
            }

            $years = range(2020, 2026);
            $defaultYear = 2026;
            $selectedYear = $sessionYear ? (int) $sessionYear : $defaultYear;
            if (!in_array($selectedYear, $years, true)) {
                $selectedYear = $defaultYear;
            }

            $view->with([
                'navProvinces' => $provinces,
                'navSelectedProvinceId' => $selectedProvinceId,
                'navViewMode' => $user?->isSuperAdmin() ? 'Global View' : 'Agency View',
                'navYears' => $years,
                'navSelectedYear' => $selectedYear,
            ]);
        });
    }
}
