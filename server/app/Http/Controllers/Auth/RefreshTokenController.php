<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RefreshTokenService;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __invoke(Request $request, RefreshTokenService $service)
    {
        $result = $service->execute(
            $request->cookie('refreshToken'),
            $request->ip(),
            $request->userAgent()
        );

        return response()
            ->json([
                'status' => 'success',
                'message' => 'Token refreshed successfully.',
                'data' => [
                    'accessToken' => $result['accessToken'],
                ],
            ])
            ->cookie(
                'refreshToken',
                $result['refreshToken'],
                60 * 24 * 7,
                null,
                null,
                app()->environment('production'),
                true,
                false,
                'Strict'
            );
    }
}
