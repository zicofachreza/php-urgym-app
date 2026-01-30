<?php

namespace App\Exceptions\Booking;

use Exception;
use Illuminate\Http\JsonResponse;

class ClassAlreadyStartedException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'This class has already started.',
        ], 400);
    }
}
