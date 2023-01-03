<?php

namespace App\Exceptions;

use App\Dto\Response\ResponseDto;
use Exception;
use Illuminate\Http\JsonResponse;

class RedisException extends Exception
{
    const REDIS_ERROR = 'redis_connection_error';

    public function report()
    {
        //
    }

    public function render($request): JsonResponse
    {
        return api_response(
            new ResponseDto(false, self::REDIS_ERROR, $this->getMessage())
        );
    }
}
