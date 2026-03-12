<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all provinces for this region
     */
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    /**
     * Get all economic data for this region
     */
    public function economicData(): HasMany
    {
        return $this->hasMany(EconomicData::class);
    }
}
