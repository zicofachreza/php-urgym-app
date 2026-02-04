<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Services\Booking\GetMyBookingsService;

class GetMyBookingsController extends Controller
{
    public function __invoke(GetMyBookingsService $service)
    {
        $bookings = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'User booking list retrieved successfully.',
            'data' => $bookings,
        ]);
    }
}
