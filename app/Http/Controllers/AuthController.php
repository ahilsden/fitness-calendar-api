<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $authenticatedUser = $this->authService->loginUser($credentials);

        if ($authenticatedUser) {
            return response()->json(['user' => $authenticatedUser]);
        }

        return response()->json(['error' => 'Incorrect credentials'], 401);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $newUser = $this->authService->registerUser($request->validated());

        return response()->json(['user' => $newUser], 201);
    }

    public function logout(): Response
    {
        Auth::guard('web')->logout();

        return response()->noContent();
    }
}
