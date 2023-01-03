<?php

namespace App\Exceptions;

use App\Dto\Response\ResponseDto;
use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    const ERROR = 'Unauthorized';

    public function report()
    {
        //
    }

    public function render($request): JsonResponse
    {
        return api_response(
            new ResponseDto(false, self::ERROR, '', 401)
        );
    }
}
