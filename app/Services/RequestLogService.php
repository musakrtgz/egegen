<?php

namespace App\Services;

use App\Models\RequestLog;

class RequestLogService
{

    public static function store(array $data): void
    {
        RequestLog::create($data);
    }

}
