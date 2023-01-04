<?php

namespace App\Services\Auth;


use App\Models\Role;
use App\Services\User\UserService;

class AuthService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registration(string $email, string $password): array
    {
        $role = Role::where('name', 'guest')->first();
        return $this->userService->create($email, $password, $role->id);
    }

}
