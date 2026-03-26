<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'agency_id',
        'name',
        'description',
        'budget',
        'status',
        'start_date',
        'end_date',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    /**
     * Get the agency this project belongs to
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}
