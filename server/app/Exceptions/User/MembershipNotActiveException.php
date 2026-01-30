<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;

class MembershipNotActiveException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Membership is not active or barcode token is missing.',
        ], 403);
    }
}
