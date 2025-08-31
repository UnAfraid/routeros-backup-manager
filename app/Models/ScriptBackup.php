<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScriptBackup extends Model
{
    protected $fillable = [
        'name',
        'content',
        'hash',
        'size',
        'version',
        'device_id',
    ];

    public function device(): BelongsTo {
        return $this->belongsTo(Device::class);
    }
}
