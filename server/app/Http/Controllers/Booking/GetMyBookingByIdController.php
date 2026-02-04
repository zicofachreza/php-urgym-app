<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Booking\GetMyBookingByIdService;

class GetMyBookingByIdController extends Controller
{
    public function __invoke(
        Booking $booking,
        GetMyBookingByIdService $service
    ) {
        $booking = $service->execute($booking);

        return response()->json([
            'status' => 'success',
            'message' => 'User booking data retrieved successfully',
            'data' => $booking,
        ]);
    }
}
