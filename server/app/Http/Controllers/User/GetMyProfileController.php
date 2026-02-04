<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\GetMyProfileService;

class GetMyProfileController extends Controller
{
    public function __invoke(GetMyProfileService $service)
    {
        $user = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile retrieved successfully',
            'data' => $user,
        ]);
    }
}
