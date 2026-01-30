<?php

namespace App\Helpers;

use App\Models\Session;

class SessionHelper
{
    public static function limitDeviceSessions($userId, $limit = 3)
    {
        $sessions = Session::where('user_id', $userId)
            ->orderBy('last_used_at', 'desc')
            ->skip($limit)
            ->take(PHP_INT_MAX)
            ->get();

        $sessions->each->delete();
    }

    public static function touchByRefreshToken($refreshToken)
    {
        $hashedToken = hash('sha256', $refreshToken);

        Session::where('hashed_token', $hashedToken)
            ->update([
                'last_used_at' => now(),
            ]);
    }
}
