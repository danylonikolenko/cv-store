<?php


namespace App\Http\Controllers\Role;


use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleAddPermissionRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleDeletePermissionRequest;
use App\Http\Requests\Role\RoleDeleteRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Services\Role\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function get(): JsonResponse
    {
        $result = $this->roleService->get();
        return $this->response($result);
    }

    public function create(RoleCreateRequest $request): JsonResponse
    {
        $params = $request->validated();
        $name = $params['name'];
        $description = $params['description'] ?? '';
        $permission_ids = $params['permission_ids'] ?? [];
        $result = $this->roleService->create($name, $description, $permission_ids);

        return $this->response($result);
    }

    public function update(RoleUpdateRequest $request): JsonResponse
    {
        $params = $request->validated();
        $id = $params['id'];
        $name = $params['name'];
        $description = $params['description'] ?? '';
        $permission_ids = $params['permission_ids'] ?? [];
        $result = $this->roleService->update($id, $name, $permission_ids, $description);

        return $this->response($result);
    }

    public function delete(RoleDeleteRequest $request): JsonResponse
    {
        $params = $request->validated();
        $id = $params['id'];
        $result = $this->roleService->delete($id);
        return $this->response($result);
    }

    public function addPermission(RoleAddPermissionRequest $request): JsonResponse
    {
        $params = $request->validated();
        $role_id = $params['role_id'];
        $permission_id = $params['permission_id'];

        $result = $this->roleService->addPermission($role_id, $permission_id);

        return $this->response($result);
    }

    /**
     * @throws ValidationException
     */
    public function deletePermission(RoleDeletePermissionRequest $request): JsonResponse
    {
        $params = $request->validated();
        $role_id = $params['role_id'];
        $permission_id = $params['permission_id'];
        $result = $this->roleService->deletePermission($role_id, $permission_id);

        return $this->response($result);
    }

}
