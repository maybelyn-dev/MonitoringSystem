<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRegistration extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'region_id',
        'province_id',
        'province',
        'year',
        'classification',
        'private',
        'private_vehicles',
        'for_hire',
        'government',
        'diplomatic',
        'exempt',
        'total',
    ];

    protected $casts = [
        'private' => 'integer',
        'private_vehicles' => 'integer',
        'for_hire' => 'integer',
        'government' => 'integer',
        'diplomatic' => 'integer',
        'exempt' => 'integer',
        'total' => 'integer',
    ];

    /**
     * Get the region this data belongs to
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the province this data belongs to
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
