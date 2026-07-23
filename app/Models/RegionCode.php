<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RegionCode extends Model
{
    protected $fillable = [
        'province_code',
        'city_code',
        'district_code',
        'label',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function isServiceable(string $provinceCode, string $cityCode, string $districtCode): bool
    {
        return static::active()
            ->where('province_code', $provinceCode)
            ->where('city_code', $cityCode)
            ->where('district_code', $districtCode)
            ->exists();
    }
}
