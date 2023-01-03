<?php


namespace App\Services\Permission;

use App\Dto\Permission\PermissionDto;
use App\Models\Permission;
use App\DtoTransformers\Permission\PermissionTransformer;
use App\Services\BaseService;
use Illuminate\Support\Facades\Route;

class PermissionService extends BaseService
{

    private PermissionTransformer $permissionTransformer;

    public function __construct(PermissionTransformer $permissionTransformer)
    {
        $this->permissionTransformer = $permissionTransformer;
    }

    /**
     * @return array|PermissionDto
     */
    public function get(): array|PermissionDto
    {
        return $this->permissionTransformer->transform(Permission::all());
    }

    /**
     * @return PermissionDto[]
     */
    public function generate(): array
    {
        $available_permissions = $this->getAvailable();
        $permissions = $this->get();
        if (count($available_permissions) === count($permissions)) {
            return [];
        }
        $tmpArrayAvailable = [];
        $tmpArrayCurrent = [];
        $tmpArrayDif = [];

        foreach ($available_permissions as $permission) {
            $tmpArrayAvailable[$this->hashArrayKey($permission)] = $permission;
        }

        foreach ($permissions as $permission) {
            $tmpArrayCurrent[$this->hashArrayKey($permission)] = $permission;
        }

        foreach ($tmpArrayAvailable as $key => $permission) {
            if (!isset($tmpArrayCurrent[$key])) {
                $tmpArrayDif[] = $permission;
            }
        }
        //remove id before insert
        $result = $this->removeIdFromArray(json_decode(json_encode($tmpArrayDif), true));
        Permission::insert($result);

        return $tmpArrayDif;
    }

    /**
     * @param PermissionDto $array
     * @return string
     */
    private function hashArrayKey(PermissionDto $array): string
    {
        return md5(json_encode([
            'route' => $array->getRoute(),
            'class_name' => $array->getClassName(),
            'function_name' => $array->getFunctionName(),
        ]));
    }

    private function removeIdFromArray(array $array): array
    {
        $result = [];
        foreach ($array as $value) {
            unset($value['id']);
            $result[] = $value;
        }
        return $result;
    }

    /**
     * @param string $route
     * @param string $className
     * @param string $functionName
     * @param string $description
     * @return PermissionDto
     */
    public function create(string $route, string $className, string $functionName, string $description = ''): PermissionDto
    {
        $permission = new Permission();
        $permission->route = $route;
        $permission->class_name = $className;
        $permission->function_name = $functionName;
        $permission->description = $description;
        $permission->save();

        return $this->permissionTransformer->transform($permission);
    }

    /**
     * @param array $request
     * @return PermissionDto
     */
    public function createFromRequest(array $request): PermissionDto
    {
        $model = new Permission();
        $params = $this->parseRequest($request, $model->getFillable());
        $permission = Permission::create($params);
        return $this->permissionTransformer->transform($permission);
    }

    /**
     * @param int $id
     * @param string|null $route
     * @param string|null $className
     * @param string|null $functionName
     * @param string|null $description
     * @return PermissionDto
     */
    public function update(int $id, ?string $route, ?string $className, ?string $functionName, ?string $description = ''): PermissionDto
    {
        $permission = Permission::find($id);

        if ($route) {
            $permission->route = $route;
        }
        if ($className) {
            $permission->class_name = $className;
        }
        if ($functionName) {
            $permission->function_name = $functionName;
        }
        if ($description) {
            $permission->description = $description;
        }
        $permission->save();

        return $this->permissionTransformer->transform($permission);
    }

    /**
     * @param array $request
     * @return PermissionDto
     */
    public function updateFromRequest(array $request): PermissionDto
    {
        $model = new Permission();
        $params = $this->parseRequest($request, $model->getFillable());
        $permission = Permission::find($params['id']);
        unset($params['id']);
        foreach ($params as $key => $value) {
            $permission->$key = $value;
        }
        $permission->save();

        return $this->permissionTransformer->transform($permission);
    }

    /**
     * @param int $id
     * @return PermissionDto
     */
    public function delete(int $id): PermissionDto
    {
        $permission = Permission::find($id);
        $permission->deleted = true;
        $permission->deleted_at = now();
        $permission->save();

        return $this->permissionTransformer->transform($permission);
    }

    /**
     * @return PermissionDto[]
     */
    public function getAvailable(): array
    {
        $permissions = [];
        foreach (Route::getRoutes() as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action)
                && str_contains($action['controller'], 'App\Http\Controllers')
                && in_array('api', $action['middleware'])) {
                $route_name = $route->uri();
                $tmp = explode('@', $action['controller']);
                $class_name = substr($tmp[0], strrpos($tmp[0], trim(' \ ')) + 1);
                $function_name = $tmp[1];
                $permissions[] = new PermissionDto(null, $route_name, $class_name, $function_name);
            }
        }
        return $permissions;
    }

}
