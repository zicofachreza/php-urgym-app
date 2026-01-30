<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Services\Payment\CreatePaymentService;

class CreatePaymentController extends Controller
{
    public function __invoke(
        MembershipPlan $membershipPlan,
        CreatePaymentService $service
    ) {
        $payment = $service->execute($membershipPlan);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment created successfully.',
            'data' => [
                'payment_id' => $payment->id,
                'snap_token' => $payment->snap_token,
                'redirect_url' => $payment->redirect_url,
            ],
        ]);
    }
}
