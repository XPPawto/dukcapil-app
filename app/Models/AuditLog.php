<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'actor_type',
        'actor_id',
        'actor_name',
        'action',
        'target_type',
        'target_id',
        'target_label',
        'ip_address',
        'user_agent',
    ];

    public static function record(
        Admin $actor,
        string $action,
        string $targetType,
        int $targetId,
        string $targetLabel,
        ?Request $request = null
    ): self {
        $request ??= request();

        return self::create([
            'actor_type' => 'admin',
            'actor_id' => $actor->id,
            'actor_name' => $actor->name,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'target_label' => $targetLabel,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);
    }
}
