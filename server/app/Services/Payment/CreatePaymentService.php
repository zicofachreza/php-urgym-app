<?php

namespace App\Services\Payment;

use App\Exceptions\Payment\ActiveMembershipException;
use App\Exceptions\Payment\PendingPaymentException;
use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CreatePaymentService
{
    public function execute(MembershipPlan $plan)
    {
        $user = Auth::user();

        $hasPendingPayment = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->first();

        if ($hasPendingPayment) {
            throw new PendingPaymentException;
        }

        $activeMembership = Payment::where('user_id', $user->id)
            ->where('status', 'paid')
            ->orderByDesc('expiry_date')
            ->first();

        if ($activeMembership && $activeMembership->expiry_date->isFuture()) {
            throw new ActiveMembershipException;
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $payment = Payment::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'amount' => $plan->discount_price ?? $plan->price,
            'status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-'.$payment->id,
                'gross_amount' => $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $user->username,
                'email' => $user->email,
            ],
        ];

        $snap = Snap::createTransaction($params);

        $payment->update([
            'midtrans_order_id' => $params['transaction_details']['order_id'],
            'snap_token' => $snap->token,
            'redirect_url' => $snap->redirect_url,
        ]);

        return $payment;
    }
}
