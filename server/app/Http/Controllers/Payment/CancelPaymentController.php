<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\CancelPaymentService;

class CancelPaymentController extends Controller
{
    public function __invoke(
        Payment $payment,
        CancelPaymentService $service
    ) {
        $service->execute($payment);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment cancelled successfully.',
            'data' => [
                'payment_id' => $payment->id,
                'status' => $payment->status,
            ],
        ]);
    }
}
