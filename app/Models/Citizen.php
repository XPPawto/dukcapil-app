<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Citizen extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'nik',
        'nik_hash',
        'dob',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'nik',
        'nik_hash',
    ];

    protected function casts(): array
    {
        return [
            'nik' => 'encrypted',
            'dob' => 'date',
            'password' => 'hashed',
            'locked_until' => 'datetime',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public static function hashNik(string $nik): string
    {
        return hash('sha256', $nik);
    }

    public static function findByNik(string $nik): ?self
    {
        return static::where('nik_hash', static::hashNik($nik))->first();
    }

    public function maskedNik(): string
    {
        $nik = $this->nik;

        return substr($nik, 0, 4).'****'.substr($nik, -4);
    }

    public function isLockedOut(): bool
    {
        return $this->status === 'locked'
            && $this->locked_until
            && $this->locked_until->isFuture();
    }
}
