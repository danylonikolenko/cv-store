<?php

namespace App\Services\Auth;

use App\Dto\Response\ResponseDto;
use App\Exceptions\UnauthorizedException;
use App\Models\Role;
use App\Models\User;
use App\Services\Cache\CacheService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private CacheService $cacheService;
    private UserService $userService;

    public function __construct(
        CacheService $cacheService,
        UserService  $userService
    )
    {
        $this->cacheService = $cacheService;
        $this->userService = $userService;
    }

    public function registration(string $email, string $password): ResponseDto
    {
        $role = Role::where('name', 'guest')->first();
        $this->userService->create($email, $password, $role->id);

        return $this->login($email, $password);
    }

    /**
     * @throws UnauthorizedException
     */
    public function auth(string $token): ResponseDto
    {
        if (!$this->cacheService->get($token)) {
            throw new UnauthorizedException();
        }

        return new ResponseDto(true, 'success');
    }

    /**
     * @throws UnauthorizedException
     */
    public function login(string $email, string $password): ResponseDto
    {
        $user = User::all()->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password) || $user->deleted) {
            throw new UnauthorizedException();
        }

        $ttl = env('TOKEN_TTL', 3600);
        $token = $this->generate_token();

        $this->cacheService->set($token, json_encode(
            [
                "key" => "user_" . $user->id,
                "user_id" => $user->id,
                "role_id" => $user->role_id,
                "username" => $user->email
            ]
        ), $ttl);

        $result = [
            'X-API-Key' => $token,
            'ttl' => $ttl
        ];

        return new ResponseDto(true, $result);
    }

    public function getUser(string $token): User
    {
        $user = $this->cacheService->get($token);
        return User::find($user['user_id']);
    }

    private function generate_token(): string
    {
        $characters = 'abhiGTv*&wAMGyz777PERFOMANCE';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}
