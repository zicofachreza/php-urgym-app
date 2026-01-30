<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Exceptions\Booking\AlreadyCancelledException;
use App\Exceptions\Booking\ClassAlreadyStartedException;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CancelBookingService
{
    public function execute(Booking $booking)
    {
        /** ClassAlreadyStarted */
        if ($booking->gymClass->schedule->isPast()) {
            throw new ClassAlreadyStartedException;
        }

        return DB::transaction(function () use ($booking) {
            $booking->lockForUpdate();

            /** AlreadyCancelled */
            if ($booking->status === BookingStatus::CANCELLED) {
                throw new AlreadyCancelledException;
            }

            /** Cancel Booking */
            $booking->update([
                'status' => BookingStatus::CANCELLED,
                'cancelled_at' => Carbon::now(),
            ]);

            return $booking->refresh();
        });
    }
}
