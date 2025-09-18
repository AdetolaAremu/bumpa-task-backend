<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseHandler;

    // registration
    public function registerUser(RegistrationRequest $request, AuthService $authService)
    {
        $authService->createUser($request);

        return $this->successResponse('User created successfully', null, 201);
    }

    // login
    public function loginUser(LoginRequest $request, AuthService $authService)
    {
        $attemptLogin = $authService->loginUser($request);

        if ($attemptLogin instanceof \Illuminate\Http\Response) return $attemptLogin;

        return $this->successResponse('User logged in successfully', $attemptLogin);
    }
}
