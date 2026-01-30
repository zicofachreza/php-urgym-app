<?php

namespace App\Exceptions\Booking;

use Exception;
use Illuminate\Http\JsonResponse;

class AlreadyCancelledException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'You have already cancelled this class.',
        ], 400);
    }
}
