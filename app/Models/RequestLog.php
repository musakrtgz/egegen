<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $fillable = [
        'method',
        'url',
        'body',
        'headers',
        'ip',
    ];

    protected $casts = [
        'body' => 'array',
        'headers' => 'array',
    ];
}
