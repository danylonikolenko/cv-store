<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
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
        $result = $this->authService->registration($params['email'], $params['password']);

        return $this->response($result);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $params = $request->validated();
        $result = $this->authService->login($params['email'], $params['password']);

        return $this->response($result);
    }

}
