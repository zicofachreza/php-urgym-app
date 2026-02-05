<?php

namespace App\Services\User;

use App\Exceptions\User\MembershipNotActiveException;
use App\Models\User;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

/**
 * Generate barcode image (used for card printing / admin export).
 * Mobile client generates barcode locally.
 */
class GenerateMembershipBarcodeService
{
    public function execute(User $user): string
    {
        if (! $user->is_member || ! $user->membership_barcode_token) {
            throw new MembershipNotActiveException;
        }

        $barcodeContent = 'GYM'.$user->membership_barcode_token;

        return DNS1D::getBarcodePNG(
            $barcodeContent,
            'C128',
            2,
            80
        );
    }
}
