<?php

namespace App\Http\Middleware;

use App\Dto\Response\ResponseDto;
use App\Exceptions\AccessException;
use App\Services\Auth\AccessService;
use App\Services\Auth\AuthService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


class Authenticate
{

    private AuthService $authService;
    private AccessService $accessService;

    public function __construct(AuthService $authService, AccessService $accessService)
    {
        $this->authService = $authService;
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
        $token = $request->header('X-API-Key');

        if (!$token) {
            $result = new ResponseDto(false, 'wrong_headers',
                'X-API-Key header is required', 422);

            return api_response($result);
        }

        $result = $this->authService->auth($token);

        if (!$result->getStatus()) {
            return api_response($result);
        }

        $user = $this->authService->getUser($request->header('X-API-Key'));
        if ($user->role_id && $user->role->name === 'admin') {
            return $next($request);
        }

        $tmp = explode('@', Route::currentRouteAction());
        $class_name = substr($tmp[0], strrpos($tmp[0], trim(' \ ')) + 1);
        $function_name = $tmp[1];

        if (!$this->accessService->checkAccess($user, $class_name, $function_name)) {
            throw new AccessException();
        }

        return $next($request);
    }

}
