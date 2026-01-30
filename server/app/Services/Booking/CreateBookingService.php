<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Exceptions\Booking\AlreadyBookedException;
use App\Exceptions\Booking\ClassAlreadyStartedException;
use App\Exceptions\Booking\ClassFullException;
use App\Exceptions\Booking\MemberOnlyException;
use App\Models\Booking;
use App\Models\GymClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateBookingService
{
    public function execute(GymClass $gymClass)
    {
        $user = Auth::user();

        /** MemberOnly */
        if (! $user->is_member || $user->membership_expires_at?->isPast()) {
            throw new MemberOnlyException;
        }

        /** ClassAlreadyStarted */
        if ($gymClass->schedule->isPast()) {
            throw new ClassAlreadyStartedException;
        }

        return DB::transaction(function () use ($gymClass, $user) {
            $lockedClass = GymClass::where('id', $gymClass->id)
                ->lockForUpdate()
                ->first();

            /** AlreadyBooked */
            $alreadyBooked = Booking::where('user_id', $user->id)
                ->where('gym_class_id', $lockedClass->id)
                ->where('status', BookingStatus::CONFIRMED)
                ->exists();

            if ($alreadyBooked) {
                throw new AlreadyBookedException;
            }

            /** ClassFull */
            $totalBooked = Booking::where('gym_class_id', $lockedClass->id)
                ->where('status', BookingStatus::CONFIRMED)
                ->count();

            if ($totalBooked >= $lockedClass->capacity) {
                throw new ClassFullException;
            }

            /** Create Booking */
            return Booking::create([
                'user_id' => $user->id,
                'gym_class_id' => $lockedClass->id,
                'booking_date' => Carbon::now(),
                'status' => BookingStatus::CONFIRMED,
            ]);
        });
    }
}
