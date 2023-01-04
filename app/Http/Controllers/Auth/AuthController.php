<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registration(RegistrationRequest $request): JsonResponse
    {
        $params = $request->validated();
        $this->authService->registration($params['email'], $params['password']);

        $token = auth()->attempt([
            'email' => $params['email'],
            'password' => $params['password']
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $params = $request->validated();

        $credentials = [
            'email' => $params['email'],
            'password' => $params['password']
        ];

        if (!$token = auth()->attempt($credentials)) {
            throw new UnauthorizedException();
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
