<?php


namespace App\DtoTransformers\User;


use App\Dto\User\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserTransformer
{
    /**
     **
     * @param Collection|User $user
     * @return UserDto[]
     */

    public function transform(Collection|User $user): array
    {
        if ($user instanceof Model) {
            return [$this->getDto($user)];
        }

        $arrayDto = [];
        foreach ($user as $value) {
            $arrayDto[] = $this->getDto($value);
        }

        return $arrayDto;
    }

    private function getDto(User $user): UserDto
    {
        return new UserDto(
            $user->id ?? null,
            $user->email ?? '',
            $user->role_id ?? null,
            $user->deleted ?? false);
    }

}
