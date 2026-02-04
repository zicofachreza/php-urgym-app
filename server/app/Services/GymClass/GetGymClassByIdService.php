<?php

namespace App\Services\GymClass;

use App\Models\GymClass;

class GetGymClassByIdService
{
    public function execute(GymClass $gymClass): GymClass
    {
        return GymClass::with('myConfirmedBooking')
            ->where('id', $gymClass->id)
            ->firstOrFail();
    }
}
