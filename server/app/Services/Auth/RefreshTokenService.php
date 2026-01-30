<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\InvalidRefreshTokenException;
use App\Exceptions\Auth\RefreshTokenReuseDetectedException;
use App\Models\Session;
use App\Utils\JwtHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RefreshTokenService
{
    public function execute($refreshToken, $ipAddress, $userAgent)
    {
        if (! $refreshToken) {
            throw new InvalidRefreshTokenException;
        }

        $payload = JwtHelper::verifyRefreshToken($refreshToken);

        if (! $payload) {
            throw new InvalidRefreshTokenException;
        }

        $hashedToken = hash('sha256', $refreshToken);

        $session = Session::with('user')
            ->where('hashed_token', $hashedToken)
            ->first();

        if (! $session) {
            // token valid tapi tidak ada di DB
            $this->revokeAllUserSessions($payload->get('sub'));
            throw new RefreshTokenReuseDetectedException;
        }

        if (! $session || $session->expires_at->isPast()) {
            throw new InvalidRefreshTokenException;
        }

        return DB::transaction(function () use ($session, $ipAddress, $userAgent) {
            // ROTATION: delete old session
            $session->delete();

            $user = $session->user;

            $newAccessToken = JwtHelper::signAccessToken($user);
            $newRefreshToken = JwtHelper::signRefreshToken($user);

            Session::create([
                'user_id' => $user->id,
                'hashed_token' => hash('sha256', $newRefreshToken),
                'device_info' => $userAgent,
                'ip_address' => $ipAddress,
                'expires_at' => Carbon::now()->addDays(7),
                'last_used_at' => Carbon::now(),
            ]);

            return [
                'accessToken' => $newAccessToken,
                'refreshToken' => $newRefreshToken,
            ];
        });
    }

    protected function revokeAllUserSessions($userId)
    {
        Session::where('user_id', $userId)->delete();
    }
}
