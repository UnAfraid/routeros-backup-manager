<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BinaryBackup extends Model
{
    protected $fillable = [
        'name',
        'path',
        'hash',
        'size',
        'version',
        'device_id',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function backup(): HasOne
    {
        return $this->hasOne(Backup::class);
    }
}
