<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class GetMyPaymentsService
{
    public function execute()
    {
        $user = Auth::user();

        return Payment::with([
            'membershipPlan:id,name,duration_months',
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
