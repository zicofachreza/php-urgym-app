<?php

namespace App\Utils;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtHelper
{
    public static function signAccessToken($user)
    {
        return JWTAuth::claims([
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'type' => 'access',
        ])->fromUser($user);
    }

    public static function signRefreshToken($user)
    {
        return JWTAuth::claims([
            'type' => 'refresh',
        ])->fromUser($user);
    }

    public static function verifyRefreshToken(string $token)
    {
        try {
            $payload = JWTAuth::setToken($token)->getPayload();

            if ($payload->get('type') !== 'refresh') {
                return null;
            }

            return $payload;
        } catch (JWTException $e) {
            return null;
        }
    }
}
