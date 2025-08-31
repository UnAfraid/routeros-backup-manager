<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordCredential extends Model
{
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    protected $casts = [
        'password' => 'encrypted',
    ];
}
