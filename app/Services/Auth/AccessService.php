<?php


namespace App\Services\Auth;


use App\Dto\Permission\PermissionDto;
use App\DtoTransformers\Permission\PermissionTransformer;
use App\Models\Permission;
use App\Models\User;

class AccessService
{

    public function checkAccess(User $user, string $class_name, string $function_name): bool
    {
        $permissions = $this->getUserPermissions($user);

        foreach ($permissions as $permission) {
            if ($permission->isDeleted()) {
                continue;
            }
            if ($permission->getClassName() === $class_name && $permission->getFunctionName() === $function_name) {
                return true;
            }
        }
        return false;
    }

    public function getUserPermissions(User $user): array|PermissionDto
    {
        $permissionIds = $user->role->permission_ids;
        $dtoTransformer = new PermissionTransformer();

        return $dtoTransformer->transform(Permission::findMany($permissionIds));
    }

}
