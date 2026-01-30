<?php

namespace App\Services\Auth;

use App\Models\Session;

class LogoutService
{
    public function execute($refreshToken, $user)
    {
        if (! $refreshToken) {
            return;
        }

        $hashedToken = hash('sha256', $refreshToken);

        Session::where('user_id', $user->id)
            ->where('hashed_token', $hashedToken)
            ->delete();
    }
}
