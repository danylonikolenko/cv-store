<?php

namespace App\Http\Middleware;

use App\Exceptions\AccessException;
use App\Services\Auth\AccessService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class CheckAccess
{
    private AccessService $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse|RedirectResponse|Response
     * @throws AccessException
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        $userId = auth()->user()->getAuthIdentifier();

        $tmp = explode('@', Route::currentRouteAction());
        $class_name = substr($tmp[0], strrpos($tmp[0], trim(' \ ')) + 1);
        $function_name = $tmp[1];

        if (!$this->accessService->checkAccess($userId, $class_name, $function_name)) {
            throw new AccessException();
        }

        return $next($request);
    }

}
