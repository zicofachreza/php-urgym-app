<?php

namespace App\Services\Booking;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class GetMyBookingByIdService
{
    public function execute(Booking $booking): Booking
    {
        $user = Auth::user();

        return Booking::with('gymClass')
            ->where('id', $booking->id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    }
}
