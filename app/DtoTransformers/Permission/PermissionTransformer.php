<?php


namespace App\DtoTransformers\Permission;


use App\Dto\Permission\PermissionDto;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class PermissionTransformer
{
    /**
     * @param Collection|Permission $permissions
     * @return PermissionDto[]|PermissionDto
     */

    #[Pure] public function transform(Collection|Permission $permissions): array|PermissionDto
    {
        if ($permissions instanceof Model) {
            return $this->getDto($permissions);
        }

        $arrayDto = [];
        foreach ($permissions as $value) {
            $arrayDto[] = $this->getDto($value);
        }
        if (count($arrayDto) === 1) {
            return $arrayDto[0];
        }

        return $arrayDto;
    }

    #[Pure] private function getDto(Permission $permissions): PermissionDto
    {
        $id = $permissions->id ?? null;
        $description = $permissions->description ?? null;
        $route = $permissions->route ?? '';
        $className = $permissions->class_name ?? '';
        $functionName = $permissions->function_name ?? '';
        $deleted = $permissions->deleted ?? false;

        return new PermissionDto($id, $route, $className, $functionName, $description, $deleted);
    }

}
