<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Backup extends Model
{
    protected $fillable = [
        'device_id',
        'success',
        'connection_error',
        'error_message',
        'started_at',
        'finished_at',
        'binary_backup_id',
        'script_backup_id',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function binaryBackup(): BelongsTo
    {
        return $this->belongsTo(BinaryBackup::class);
    }

    public function scriptBackup(): BelongsTo
    {
        return $this->belongsTo(ScriptBackup::class);
    }
}
