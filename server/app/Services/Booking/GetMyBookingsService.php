<?php

namespace App\Services\Booking;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class GetMyBookingsService
{
    public function execute()
    {
        $user = Auth::user();

        return Booking::with('gymClass')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
