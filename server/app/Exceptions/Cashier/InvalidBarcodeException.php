<?php

namespace App\Exceptions\Cashier;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidBarcodeException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid barcode format.',
        ], 400);
    }
}
