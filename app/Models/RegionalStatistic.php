<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalStatistic extends Model
{
    use HasFactory;

    protected $table = 'regional_statistics';

    protected $fillable = [
        'province',
        'category',
        'sub_category',
        'year',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];
}
