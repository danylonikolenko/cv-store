<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyDeleteRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function get(): JsonResponse
    {
        $result = $this->companyService->get();
        return $this->response($result);
    }

    public function create(CompanyCreateRequest $request): JsonResponse
    {
        $result = $this->companyService->createFromRequest($request->validated());
        return $this->response($result);
    }

    public function update(CompanyUpdateRequest $request): JsonResponse
    {
        $result = $this->companyService->updateFromRequest($request->validated());
        return $this->response($result);
    }

    public function delete(CompanyDeleteRequest $request): JsonResponse
    {
        $result = $this->companyService->delete($request->validated()['id']);
        return $this->response($result);
    }

}
