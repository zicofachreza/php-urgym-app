<?php

namespace App\Http\Controllers\GymClass;

use App\Http\Controllers\Controller;
use App\Services\GymClass\GetAllGymClassService;

class GetAllGymClassController extends Controller
{
    public function __invoke(GetAllGymClassService $service)
    {
        $gymClasses = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'Gym class list retrieved successfully.',
            'data' => $gymClasses,
        ]);
    }
}
