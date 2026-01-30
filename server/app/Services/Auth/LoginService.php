<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Helpers\SessionHelper;
use App\Models\Session;
use App\Models\User;
use App\Utils\JwtHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function execute($email, $password, $ipAddress, $userAgent)
    {
        $user = User::where('email', $email)
            ->orWhere('username', $email)
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException;
        }

        $accessToken = JwtHelper::signAccessToken($user);
        $refreshToken = JwtHelper::signRefreshToken($user);

        $hashedToken = hash('sha256', $refreshToken);

        DB::transaction(function () use ($user, $hashedToken, $ipAddress, $userAgent) {
            Session::create([
                'user_id' => $user->id,
                'hashed_token' => $hashedToken,
                'device_info' => $userAgent,
                'ip_address' => $ipAddress,
                'expires_at' => Carbon::now()->addDays(7),
                'last_used_at' => Carbon::now(),
            ]);

            SessionHelper::limitDeviceSessions($user->id);
        });

        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];
    }
}
