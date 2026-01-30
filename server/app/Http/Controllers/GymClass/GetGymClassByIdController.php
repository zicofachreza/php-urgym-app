<?php

namespace App\Http\Controllers\GymClass;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Services\GymClass\GetGymClassByIdService;

class GetGymClassByIdController extends Controller
{
    public function __invoke(GymClass $gymClass, GetGymClassByIdService $service)
    {
        $gymClass = $service->execute($gymClass);

        return response()->json([
            'status' => 'success',
            'message' => 'Gym class data retrieved successfully.',
            'data' => $gymClass,
        ]);
    }
}
