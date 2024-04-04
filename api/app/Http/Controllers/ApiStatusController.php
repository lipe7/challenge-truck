<?php

namespace App\Http\Controllers;

use App\Domain\ApiStatus\ApiStatusService;

class ApiStatusController extends Controller
{
    protected $apiStatusService;

    public function __construct(ApiStatusService $apiStatusService)
    {
        $this->apiStatusService = $apiStatusService;
    }

    public function apiDetails()
    {
        $apiDetails = $this->apiStatusService->getApiDetails();
        return response()->json($apiDetails);
    }
}
