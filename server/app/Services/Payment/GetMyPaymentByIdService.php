<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class GetMyPaymentByIdService
{
    public function execute(Payment $payment): Payment
    {
        $user = Auth::user();

        return Payment::with('membershipPlan')
            ->where('id', $payment->id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    }
}
