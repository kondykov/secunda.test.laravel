<?php

namespace App\Http\Middleware;

use App\Models\ApiStaticKey;
use App\Utils\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticApiKeyAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-Key');

        if (empty($token)) {
            return ApiResponse::error('Unauthorized', status: 401);
        }

        $exists = ApiStaticKey::where('key', $token)->first();
        if (!$exists) {
            return ApiResponse::error('Unauthorized', status: 401);
        }

        return $next($request);
    }
}
