<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'agency_name',
        'agency_id',
        'province_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const ROLE_ADMIN = 'admin';
    public const ROLE_FOCAL = 'focal';
    public const ROLE_FOCAL_VIEWER = 'focal_viewer';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isFocal(): bool
    {
        return $this->role === self::ROLE_FOCAL;
    }

    public function isFocalViewer(): bool
    {
        return $this->role === self::ROLE_FOCAL_VIEWER;
    }

    public function canWrite(): bool
    {
        return $this->isAdmin() || $this->isFocal();
    }

    public function canManageProvinceId(?int $provinceId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        if (!$provinceId || !$this->province_id) {
            return false;
        }
        return (int) $provinceId === (int) $this->province_id;
    }

    public function canManageProvinceName(?string $provinceName): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        $userProvince = $this->province?->name;
        if (!$provinceName || !$userProvince) {
            return false;
        }
        return strcasecmp($provinceName, $userProvince) === 0;
    }

    public function canManageAgencyName(?string $agencyName): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        if (!$agencyName || !$this->agency_name) {
            return false;
        }
        return strcasecmp($agencyName, $this->agency_name) === 0;
    }

    /**
     * Get the agency this user belongs to
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Province preference for filtering Region III monitoring data.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
