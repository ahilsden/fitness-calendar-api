<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function loginUser(array $credentials): User | bool
    {
        $user = User::whereEmail($credentials['email'])->first();

        if ($user && Auth::attempt($credentials)) {
            return $user;
        }

        return false;
    }

    public function registerUser(array $request): User
    {
        $request['password'] = bcrypt($request['password']);

        return User::create($request);
    }
}
