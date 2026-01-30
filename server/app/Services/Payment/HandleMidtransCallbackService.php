<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HandleMidtransCallbackService
{
    public function execute(array $payload): void
    {
        // Defensive: payload kosong / test
        if (! isset($payload['order_id'])) {
            return;
        }

        // Signature check (JANGAN abort)
        if (! $this->isValidSignature($payload)) {
            logger()->warning('Invalid Midtrans signature', $payload);

            return;
        }

        $payment = Payment::where(
            'midtrans_order_id',
            $payload['order_id']
        )->first();

        // Test notification sering tidak ada di DB
        if (! $payment) {
            return;
        }

        if (isset($payload['transaction_id']) && ! $payment->midtrans_transaction_id) {
            $payment->update([
                'midtrans_transaction_id' => $payload['transaction_id'],
            ]);
        }

        match ($payload['transaction_status'] ?? null) {
            'settlement' => $this->handlePaid($payment),
            'expire' => $payment->update(['status' => 'expired']),
            'cancel', 'deny' => $payment->update(['status' => 'failed']),
            default => null,
        };
    }

    protected function handlePaid(Payment $payment): void
    {
        if ($payment->status === 'paid') {
            return; // idempotent
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'paid',
                'start_date' => now(),
                'expiry_date' => now()->addMonths(
                    $payment->membershipPlan->duration_months
                ),
            ]);

            $payment->user->update([
                'is_member' => true,
                'membership_expires_at' => $payment->expiry_date,
                'membership_barcode_token' => Str::uuid(),
            ]);
        });
    }

    protected function isValidSignature(array $payload): bool
    {
        if (! isset(
            $payload['signature_key'],
            $payload['order_id'],
            $payload['status_code'],
            $payload['gross_amount']
        )) {
            return false;
        }

        $signature = hash(
            'sha512',
            $payload['order_id'].
            $payload['status_code'].
            $payload['gross_amount'].
            config('midtrans.server_key')
        );

        return hash_equals($signature, $payload['signature_key']);
    }
}
