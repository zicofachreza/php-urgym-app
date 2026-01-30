<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\HandleMidtransCallbackService;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // proses async / aman
            app(HandleMidtransCallbackService::class)
                ->execute($request->all());
        } catch (\Throwable $e) {
            // log saja, JANGAN balas error
            logger()->error('Midtrans callback error', [
                'error' => $e->getMessage(),
            ]);
        }

        // MIDTRANS HANYA PEDULI INI
        return response('OK', 200);
    }
}
