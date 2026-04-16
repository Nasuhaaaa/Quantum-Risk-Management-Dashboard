<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AuditLogger
{
    public static function log(
        string $action,
        string $module,
        ?string $description = null,
        ?Model $model = null,
        array $oldValues = [],
        array $newValues = [],
        ?string $username = null,
        ?int $userId = null
    ): void {
        if (!Schema::hasTable('audit_logs')) {
            return;
        }

        $request = request();
        $user = auth()->user();

        AuditLog::create([
            'user_id' => $userId ?? $user?->id,
            'username' => $username ?? $user?->username,
            'action' => $action,
            'module' => $module,
            'auditable_type' => $model ? class_basename($model) : null,
            'auditable_id' => $model?->getKey(),
            'description' => $description,
            'old_values' => empty($oldValues) ? null : $oldValues,
            'new_values' => empty($newValues) ? null : $newValues,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
