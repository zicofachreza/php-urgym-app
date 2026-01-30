<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterService $service)
    {
        $data = $request->validated();

        $user = $service->execute(
            $data['username'],
            $data['email'],
            $data['password']
        );

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'data' => $user,
        ], 201);
    }
}
