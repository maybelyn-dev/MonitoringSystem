<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    use HasFactory;

    protected $table = 'statistics';

    protected $fillable = [
        'province_id',
        'year',
        'value',
        'category_id',
        'table_reference',
    ];

    protected $casts = [
        'year' => 'integer',
        'value' => 'decimal:2',
    ];

    /**
     * Get the province that owns this statistic.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeForYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeForCategoryId($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Group totals by province for compact dashboards.
     */
    public function scopeSumByProvince($query)
    {
        return $query
            ->select('province_id')
            ->selectRaw('SUM(value) as total_value')
            ->groupBy('province_id');
    }
}
