<?php

namespace App\Http\Controllers;

use App\Dto\Response\ResponseDto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response(mixed $response): JsonResponse
    {
        if ($response instanceof ResponseDto) {
            return api_response($response);
        }

        return api_response(
            new ResponseDto(true, $response)
        );
    }
}
