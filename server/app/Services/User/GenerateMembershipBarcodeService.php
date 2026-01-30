<?php

namespace App\Services\User;

use App\Exceptions\User\MembershipNotActiveException;
use App\Models\User;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;

class GenerateMembershipBarcodeService
{
    public function execute(User $user): string
    {
        if (! $user->is_member || ! $user->membership_barcode_token) {
            throw new MembershipNotActiveException;
        }

        $barcodeContent = 'GYM|'.$user->membership_barcode_token;

        return DNS2D::getBarcodePNG(
            $barcodeContent,
            'QRCODE',
            10,
            10
        );
    }
}
