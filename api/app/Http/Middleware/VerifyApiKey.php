<?php

namespace App\Http\Middleware;

use App\Domain\ApiStatus\ApiStatusRepository;
use Closure;

class VerifyApiKey
{
    protected $apiStatusRepository;

    public function __construct(ApiStatusRepository $apiStatusRepository)
    {
        $this->apiStatusRepository = $apiStatusRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key is missing'], 401);
        }

        $apiKeyModel = $this->apiStatusRepository->verifyApiKey($apiKey);
        if (!$apiKeyModel) {
            return response()->json(['error' => 'Invalid API Key'], 401);
        }

        return $next($request);
    }
}
