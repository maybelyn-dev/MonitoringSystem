<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EconomicData extends Model
{
    protected $fillable = [
        'region_id',
        'province_id',
        'year',
        'banking_liabilities',
        'universal_banks',
        'thrift_banks',
        'rural_banks',
        'operating_income',
        'data_type',
    ];

    protected $casts = [
        'banking_liabilities' => 'decimal:2',
        'universal_banks' => 'decimal:2',
        'thrift_banks' => 'decimal:2',
        'rural_banks' => 'decimal:2',
        'operating_income' => 'decimal:2',
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
