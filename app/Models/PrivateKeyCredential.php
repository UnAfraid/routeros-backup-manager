<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateKeyCredential extends Model
{
    protected $fillable = [
        'name',
        'username',
        'private_key',
        'passphrase',
    ];

    protected $casts = [
        'private_key' => 'encrypted',
        'passphrase' => 'encrypted',
    ];
}
