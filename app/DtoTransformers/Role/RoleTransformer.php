<?php


namespace App\DtoTransformers\Role;


use App\Dto\Role\RoleDto;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class RoleTransformer
{
    /**
     **
     * @param Collection|Role $roles
     * @return RoleDto[]|RoleDto
     */

    #[Pure] public function transform(Collection|Role $roles): array|RoleDto
    {
        if ($roles instanceof Model) {
            return $this->getDto($roles);
        }

        $arrayDto = [];
        foreach ($roles as $value) {
            $arrayDto[] = $this->getDto($value);
        }
        if (count($arrayDto) === 1) {
            return $arrayDto[0];
        }

        return $arrayDto;
    }

    #[Pure] private function getDto(Role $role): RoleDto
    {
        $id_role = $role->id ?? null;
        $description = $role->description ?? '';
        $name = $role->name ?? '';
        $permission_ids = array_values($role->permission_ids ?? []);
        $permissions = [];
        foreach ($permission_ids as $id) {
            $permission = Permission::find($id);
            if($permission){
                $permissions[$id] = [
                    'route' => $permission->route,
                    'name' => $permission->class_name . '/' . $permission->function_name
                ];
            }

        }
        $deleted = $role->deleted ?? false;

        return new RoleDto($id_role, $name, $permissions, $description, $deleted);
    }

}
