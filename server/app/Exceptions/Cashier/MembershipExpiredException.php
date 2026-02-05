<?php

namespace App\Exceptions\Cashier;

use Exception;
use Illuminate\Http\JsonResponse;

class MembershipExpiredException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Membership expired.',
        ], 403);
    }
}
