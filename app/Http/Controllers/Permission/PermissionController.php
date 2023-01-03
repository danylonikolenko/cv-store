<?php


namespace App\Http\Controllers\Permission;


use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionDeleteRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Services\Permission\PermissionService;
use Illuminate\Http\JsonResponse;


class PermissionController extends Controller
{

    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }


    public function getAvailable(): JsonResponse
    {
        $result = $this->permissionService->getAvailable();
        return $this->response($result);
    }

    public function get(): JsonResponse
    {
        $result = $this->permissionService->get();
        return $this->response($result);
    }

    public function generate(): JsonResponse
    {
        $result = $this->permissionService->generate();
        return $this->response($result);
    }

    public function create(PermissionCreateRequest $request): JsonResponse
    {
        $result = $this->permissionService->createFromRequest($request->validated());
        return $this->response($result);
    }

    public function update(PermissionUpdateRequest $request): JsonResponse
    {
        $result = $this->permissionService->updateFromRequest($request->validated());
        return $this->response($result);
    }

    public function delete(PermissionDeleteRequest $request): JsonResponse
    {
        $result = $this->permissionService->delete($request->validated()['id']);
        return $this->response($result);
    }

}
