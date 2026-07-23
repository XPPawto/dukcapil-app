<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    protected $fillable = [
        'submission_id',
        'file_type',
        'field_name',
        'storage_key',
        'original_name',
        'mime_type',
        'size',
        'uploaded_by_type',
        'uploaded_by_id',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function uploadedBy(): MorphTo
    {
        return $this->morphTo();
    }
}
