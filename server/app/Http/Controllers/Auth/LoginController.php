<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginService $service)
    {
        $data = $request->validated();

        $result = $service->execute(
            $data['email'],
            $data['password'],
            $request->ip(),
            $request->userAgent()
        );

        return response()
            ->json([
                'status' => 'success',
                'message' => 'User log in successfully.',
                'data' => $result,
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
