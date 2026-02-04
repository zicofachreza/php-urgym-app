<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Services\Booking\CreateBookingService;

class CreateBookingController extends Controller
{
    public function __invoke(GymClass $gymClass, CreateBookingService $service)
    {
        $booking = $service->execute($gymClass);

        return response()->json([
            'status' => 'success',
            'message' => 'Class booked successfully.',
            'data' => $booking,
        ]);
    }
}
