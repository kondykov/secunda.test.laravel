<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, int $status = 200): JsonResponse
    {
        return self::getJsonResponse($data, $status);
    }

    public static function error($data = null, int $status = 400): JsonResponse
    {
        return self::getJsonResponse($data, $status);
    }

    public static function created($data = null): JsonResponse
    {
        return self::success($data, 201);
    }

    /**
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    public static function getJsonResponse(mixed $data, int $status): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }
}
