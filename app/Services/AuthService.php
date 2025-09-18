<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseHandler;

class AuthService
{
    use ResponseHandler;

    public function createUser($request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password)
        ]);
    }

    public function getUserByEmail($email)
    {
        $email = strtolower($email);

        return User::where('email', $email)->first();
    }

    public function validatePassword($user, $password)
    {
        return password_verify($password, $user->password);
    }

    public function loginUser($request)
    {
        $getUser = $this->getUserByEmail($request->email);

        if (!$getUser) {
            return $this->errorResponse('User not found or credentials incorrect', 404);
        }

        if (!$this->validatePassword($getUser, $request->password)) {
            return $this->errorResponse('Invalid credentials, password and/or email mismatch', 401);
        }

        return $getUser->createToken('users')->accessToken;
    }
}
