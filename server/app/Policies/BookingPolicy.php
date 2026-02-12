<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function cancel(User $user, Booking $booking): Response|bool
    {
        if ($booking->user_id !== $user->id) {
            return Response::deny('You are not allowed to cancel this booking.');
        }

        return Response::allow();
    }
}
