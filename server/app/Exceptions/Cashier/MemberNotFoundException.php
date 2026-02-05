<?php

namespace App\Exceptions\Cashier;

use Exception;
use Illuminate\Http\JsonResponse;

class MemberNotFoundException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Member not found.',
        ], 404);
    }
}
