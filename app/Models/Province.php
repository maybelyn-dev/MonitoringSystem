<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = [
        'region_id',
        'name',
        'code',
        'data_status',
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
}
