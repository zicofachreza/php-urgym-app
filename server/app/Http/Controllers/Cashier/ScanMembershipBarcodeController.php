<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\ScanMembershipBarcodeRequest;
use App\Services\Cashier\ScanMembershipBarcodeService;

class ScanMembershipBarcodeController extends Controller
{
    public function __invoke(
        ScanMembershipBarcodeRequest $request,
        ScanMembershipBarcodeService $service
    ) {
        $data = $request->validated();

        $user = $service->execute($data['barcode']);

        return response()->json([
            'status' => 'success',
            'message' => 'Membership valid.',
            'data' => [
                'user_id' => $user->id,
                'username' => $user->username,
                'expires_at' => $user->membership_expires_at,
            ],
        ]);
    }
}
