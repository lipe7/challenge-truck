<?php

namespace App\Domain\ApiStatus;

use App\Domain\ImportHistory\ImportHistory;

class ApiStatusRepository
{
    public function getLastCronRun()
    {
        return ImportHistory::latest()->first()?->start_time;
    }

    public function verifyApiKey($apiKey)
    {
        return ApiKey::where('key', $apiKey)->first();
    }
}
