<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\GetUserByIdService;

class GetUserByIdController extends Controller
{
    public function __invoke(User $user, GetUserByIdService $service)
    {
        $user = $service->execute($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User data retrieved successfully.',
            'data' => $user,
        ]);
    }
}
