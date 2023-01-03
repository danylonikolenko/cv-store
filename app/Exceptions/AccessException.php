<?php

namespace App\Exceptions;

use App\Dto\Response\ResponseDto;
use Exception;
use Illuminate\Http\JsonResponse;

class AccessException extends Exception
{
    const ERROR = 'Access denied';

    public function report()
    {
        //
    }

    public function render($request): JsonResponse
    {
        return api_response(
            new ResponseDto(false, self::ERROR, '', 403)
        );
    }
}
