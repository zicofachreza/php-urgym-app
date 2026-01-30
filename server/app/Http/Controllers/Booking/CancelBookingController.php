<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Booking\CancelBookingService;

class CancelBookingController extends Controller
{
    public function __invoke(Booking $booking, CancelBookingService $service)
    {
        $booking = $service->execute($booking);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking cancelled successfully.',
            'data' => [
                'booking_id' => $booking->id,
                'status' => $booking->status,
                'available_slots' => $booking->gymClass->available_slots,
            ],
        ]);
    }
}
