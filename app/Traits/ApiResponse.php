<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse {
    
    protected function success(mixed $payload, $message = 'success', int $code = 200): JsonResponse
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $payload
        ], $code);
    }

    protected function error($message = 'error', $code = 500, mixed $payload = [], ): JsonResponse
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $payload
        ], $code);
    }
}