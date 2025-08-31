<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Device extends Model
{
    protected $fillable = [
        'name',
        'address',
        'port',
        'credential_type',
        'credential_id',
        'backup_cron_schedule',
        'binary_backup_enabled',
        'script_backup_enabled',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'binary_backup_enabled' => 'boolean',
        'script_backup_enabled' => 'boolean',
    ];

    public function credential(): MorphTo
    {
        return $this->morphTo();
    }

    public function binaryBackups(): HasMany
    {
        return $this->hasMany(BinaryBackup::class);
    }

    public function scriptBackups(): HasMany
    {
        return $this->hasMany(ScriptBackup::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by_user_id = auth()->id();
            $model->updated_by_user_id = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by_user_id = auth()->id();
        });
    }
}
