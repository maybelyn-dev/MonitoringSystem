<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = [
        'name',
<<<<<<< HEAD
        'code',
        'data_status',
=======
        'region_id',
>>>>>>> cf987bb09545d4af71f7cee8ba04d0b7d536a31c
    ];

    /**
     * Get the region this province belongs to
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get all economic data for this province
     */
    public function economicData(): HasMany
    {
        return $this->hasMany(EconomicData::class);
    }

    /**
     * Get all vehicle registrations for this province
     */
    public function vehicleRegistrations(): HasMany
    {
        return $this->hasMany(VehicleRegistration::class);
    }

    /**
     * Get all statistics for this province.
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }

    /**
     * Eager-load a summed value for statistics, with optional filters.
     */
    public function scopeWithStatisticsTotal($query, ?int $year = null, ?string $category = null)
    {
        return $query->withSum(
            [
                'statistics as statistics_total' => function ($stats) use ($year, $category) {
                    if ($year !== null) {
                        $stats->where('year', $year);
                    }
                    if ($category !== null) {
                        $stats->whereHas('category', fn ($q) => $q->where('name', $category));
                    }
                },
            ],
            'value'
        );
    }
}
