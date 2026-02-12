<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\GetMyPaymentByIdService;

class GetMyPaymentByIdController extends Controller
{
    public function __invoke(Payment $payment, GetMyPaymentByIdService $service)
    {
        $payment = $service->execute($payment);

        return response()->json([
            'status' => 'success',
            'message' => 'User payment data retrieved successfully',
            'data' => $payment,
        ]);
    }
}
