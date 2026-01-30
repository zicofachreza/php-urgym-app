<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request, LogoutService $service)
    {
        $service->execute(
            $request->cookie('refreshToken'),
            $request->user()
        );

        return response()
            ->json([
                'status' => 'success',
                'message' => 'Logged out successfully.',
            ])
            ->withoutCookie('refreshToken');
    }
}
