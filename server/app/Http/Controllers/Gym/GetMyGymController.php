<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Services\Gym\GetMyGymService;

class GetMyGymController extends Controller
{
    public function __invoke(GetMyGymService $service)
    {
        $gym = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'User gym data retrieved successfully.',
            'data' => $gym,
        ]);
    }
}
