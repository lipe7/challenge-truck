<?php

namespace App\Domain\ApiStatus;

use Illuminate\Support\Facades\DB;

class ApiStatusService
{
    protected $apiStatusRepository;

    public function __construct(ApiStatusRepository $apiStatusRepository)
    {
        $this->apiStatusRepository = $apiStatusRepository;
    }

    public function getApiDetails()
    {
        try {
            $dbConnection = $this->checkMongoDBConnection();

            $lastCronRun = $this->apiStatusRepository->getLastCronRun();

            $uptime = shell_exec('uptime');
            $memoryUsage = memory_get_usage(true);

            return [
                'db_connection' => $dbConnection,
                'last_cron_run' => $lastCronRun,
                'uptime' => $uptime,
                'memory_usage' => $memoryUsage,
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    protected function checkMongoDBConnection()
    {
        try {
            DB::connection('mongodb')->getPdo();
            return 'Connection to MongoDB is OK';
        } catch (\Exception $e) {
            throw new \Exception('Failed to connect to MongoDB');
        }
    }
}
