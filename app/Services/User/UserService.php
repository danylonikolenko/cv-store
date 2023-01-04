<?php

namespace App\Services\User;

use App\DtoTransformers\User\UserTransformer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private UserTransformer $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    public function create(string $email, string $password, int $roleId = null): array
    {
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        if ($roleId) {
            $user->role_id = $roleId;
        }
        $user->save();

        return $this->userTransformer->transform($user);
    }

}
