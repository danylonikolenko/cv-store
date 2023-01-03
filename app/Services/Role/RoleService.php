<?php


namespace App\Services\Role;


use App\Dto\Role\RoleDto;
use App\DtoTransformers\Role\RoleTransformer;
use App\Models\Role;
use Illuminate\Validation\ValidationException;

class RoleService
{

    private RoleTransformer $roleTransformer;

    public function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }


    /**
     * @return RoleDto[]|RoleDto
     */
    public function get(): array|RoleDto
    {
        return $this->roleTransformer->transform(Role::all());
    }

    /**
     * @param string $name
     * @param string $description
     * @param array $permission_ids
     * @return RoleDto
     */
    public function create(string $name, string $description = '', array $permission_ids = []): RoleDto
    {
        $role = new Role();
        $role->name = $name;
        $role->description = $description;
        if (!empty($permission_ids)) {
            $role->permission_ids = $permission_ids;
        }
        $role->save();

        return $this->roleTransformer->transform($role);
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param array $permission_ids
     * @param string|null $description
     * @return RoleDto
     */
    public function update(int $id, ?string $name = null, array $permission_ids = [], ?string $description = null): RoleDto
    {
        $role = Role::find($id);
        if ($name) {
            $role->name = $name;
        }
        if ($description) {
            $role->description = $description;
        }
        if (!empty($permission_ids)) {
            $role->permission_ids = $permission_ids;
        }
        $role->save();

        return $this->roleTransformer->transform($role);
    }

    /**
     * @param int $id
     * @return RoleDto
     */
    public function delete(int $id): RoleDto
    {
        $role = Role::find($id);
        $role->deleted = true;
        $role->deleted_at = now();

        return $this->roleTransformer->transform($role);
    }

    /**
     * @param int $role_id
     * @param int $permission_id
     * @return RoleDto
     */
    public function addPermission(int $role_id, int $permission_id): RoleDto
    {
        $role = Role::find($role_id);
        $permission_ids = $role->permission_ids;
        $permission_ids[] = $permission_id;
        $permission_ids = array_unique($permission_ids);
        $role->permission_ids = $permission_ids;
        $role->save();

        return $this->roleTransformer->transform($role);
    }

    /**
     * @param int $role_id
     * @param int $permission_id
     * @return RoleDto
     * @throws ValidationException
     */
    public function deletePermission(int $role_id, int $permission_id): RoleDto
    {
        $role = Role::find($role_id);
        $permission_ids = $role->permission_ids;
        if (($key = array_search($permission_id, $permission_ids)) !== false) {
            unset($permission_ids[$key]);
        }else{
            throw ValidationException::withMessages(['permission' => 'the role does not have this permission']);
        }
        $role->permission_ids = $permission_ids;
        $role->save();

        return $this->roleTransformer->transform($role);
    }

}
