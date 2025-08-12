<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::whereEmail($request['email'])->first();

        if ($user && Auth::attempt($credentials)) {
            return response()->json(['user' => $user]);
        }

        return response()->json(['error' => 'Incorrect credentials'], 401);
    }
}
