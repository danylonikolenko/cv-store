<?php

namespace App\Http\Controllers;

use App\Exceptions\DbException;
use App\Exceptions\RedisException;
use App\Services\Ping\PingService;
use Illuminate\Http\JsonResponse;

class PingController extends Controller
{

    private PingService $service;

    public function __construct(PingService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws DbException
     * @throws RedisException
     */
    public function ping(): JsonResponse
    {
        return $this->response($this->service->ping());
    }
}
