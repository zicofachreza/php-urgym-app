<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\GenerateMembershipBarcodeService;
use Illuminate\Support\Facades\Auth;

class GetMembershipBarcodeController extends Controller
{
    public function __invoke(GenerateMembershipBarcodeService $service)
    {
        $barcode = $service->execute(Auth::user());

        return response()->json([
            'status' => 'success',
            'message' => 'Membership barcode retrieved successfully.',
            'data' => [
                'barcode' => $barcode,
                'username' => Auth::user()->username,
                'expires_at' => Auth::user()->membership_expires_at,
            ],
        ]);
    }
}
