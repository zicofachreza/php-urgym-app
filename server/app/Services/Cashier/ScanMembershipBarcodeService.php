<?php

namespace App\Services\Cashier;

use App\Exceptions\Cashier\InvalidBarcodeException;
use App\Exceptions\Cashier\MemberNotFoundException;
use App\Exceptions\Cashier\MembershipExpiredException;
use App\Exceptions\User\MembershipNotActiveException;
use App\Models\User;
use Carbon\Carbon;

class ScanMembershipBarcodeService
{
    public function execute(string $barcode): User
    {
        if (! $this->isValidFormat($barcode)) {
            throw new InvalidBarcodeException;
        }

        $user = User::where('membership_barcode_token', $barcode)->first();

        if (! $user) {
            throw new MemberNotFoundException;
        }

        if (! $user->is_member) {
            throw new MembershipNotActiveException;
        }

        if (
            $user->membership_expires_at &&
            Carbon::parse($user->membership_expires_at)->isPast()
        ) {
            throw new MembershipExpiredException;
        }

        return $user;
    }

    protected function isValidFormat(string $barcode): bool
    {
        return preg_match(
            '/^GYM[0-9A-F]{32}$/',
            $barcode
        ) === 1;
    }
}
