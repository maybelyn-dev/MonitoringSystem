<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    protected $fillable = [
        'agency_name',
        'province',
        'address',
        'contact',
    ];

    /**
     * Get all users for this agency
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all projects for this agency
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
