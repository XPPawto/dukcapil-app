<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public const SERVICE_LABELS = [
        'kk' => 'Kartu Keluarga',
        'akta-lahir' => 'Akta Kelahiran',
        'akta-mati' => 'Akta Kematian',
    ];

    public const TICKET_PREFIXES = [
        'kk' => 'KK',
        'akta-lahir' => 'AL',
        'akta-mati' => 'AM',
    ];

    protected $fillable = [
        'ticket_number',
        'citizen_id',
        'service_type',
        'form_data',
        'status',
        'note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'form_data' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class);
    }

    public function serviceLabel(): string
    {
        return self::SERVICE_LABELS[$this->service_type] ?? $this->service_type;
    }

    public static function generateTicketNumber(string $serviceType): string
    {
        $prefix = self::TICKET_PREFIXES[$serviceType] ?? 'PM';

        do {
            $candidate = sprintf(
                '%s-%s-%04d',
                $prefix,
                now()->format('Ymd'),
                random_int(1, 9999)
            );
        } while (self::where('ticket_number', $candidate)->exists());

        return $candidate;
    }
}
