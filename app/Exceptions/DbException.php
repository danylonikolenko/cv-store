<?php

namespace App\Exceptions;

use App\Dto\Response\ResponseDto;
use Exception;
use Illuminate\Http\JsonResponse;

class DbException extends Exception
{
    const DB_ERROR = 'database_connection_error';

    public function report()
    {
        //
    }

    public function render($request): JsonResponse
    {
        return api_response(
            new ResponseDto(false, self::DB_ERROR, $this->getMessage())
        );
    }
}
