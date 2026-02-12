<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Exceptions\Payment\PaymentCancelledException;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Transaction;
use Throwable;

class CancelPaymentService
{
    public function execute(Payment $payment): Payment
    {
        // hanya boleh cancel pending
        if ($payment->status !== PaymentStatus::PENDING) {
            throw new PaymentCancelledException;
        }

        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        // cancel di Midtrans (aman walau sudah expired)
        if ($payment->midtrans_order_id) {
            try {
                Transaction::cancel($payment->midtrans_order_id);
            } catch (Throwable $e) {
                logger()->warning('Midtrans cancel failed', [
                    'order_id' => $payment->midtrans_order_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $payment->update([
            'status' => PaymentStatus::CANCELLED,
        ]);

        return $payment;
    }
}
