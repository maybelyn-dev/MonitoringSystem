<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EconomicData extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'region_id',
        'province_id',
        'province',
        'year',
        'total',
        'banking_liabilities',
        'universal_commercial_banks',
        'universal_banks',
        'thrift_banks',
        'rural_cooperative_banks',
        'rural_banks',
        'operating_income',
        'data_type',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'banking_liabilities' => 'decimal:2',
        'universal_commercial_banks' => 'decimal:2',
        'universal_banks' => 'decimal:2',
        'thrift_banks' => 'decimal:2',
        'rural_cooperative_banks' => 'decimal:2',
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
