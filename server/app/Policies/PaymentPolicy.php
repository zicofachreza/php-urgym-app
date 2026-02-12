<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    public function cancel(User $user, Payment $payment): Response|bool
    {
        if ($payment->user_id !== $user->id) {
            return Response::deny('You are not allowed to cancel this payment.');
        }

        return Response::allow();
    }
}
