<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\GetMyPaymentsService;

class GetMyPaymentsController extends Controller
{
    public function __invoke(GetMyPaymentsService $service)
    {
        $payments = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'User payment list retrieved successfully.',
            'data' => $payments,
        ]);
    }
}
