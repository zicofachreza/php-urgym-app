<?php

namespace App\Exceptions\Payment;

use Exception;
use Illuminate\Http\JsonResponse;

class PendingPaymentException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'You still have a pending payment. Please complete or cancel it before creating a new one.',
        ], 422);
    }
}
