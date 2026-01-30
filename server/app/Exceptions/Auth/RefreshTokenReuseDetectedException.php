<?php

namespace App\Exceptions\Auth;

use Exception;
use Illuminate\Http\JsonResponse;

class RefreshTokenReuseDetectedException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Suspicious activity detected. Please log in again.',
        ], 401);
    }
}
