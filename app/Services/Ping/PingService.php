<?php

namespace App\Services\Ping;

use App\Dto\Response\ResponseDto;
use App\Exceptions\DbException;
use App\Exceptions\RedisException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PingService
{

    /**
     * @throws DbException
     * @throws RedisException
     */
    public function ping(): ResponseDto
    {
        $this->checkDbConnection();
        $this->checkRedisConnection();

        return new ResponseDto(true, 'pong');
    }

    /**
     * @throws DbException
     */
    private function checkDbConnection(): void
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception) {
            throw new DbException();
        }
    }

    /**
     * @throws RedisException
     */
    private function checkRedisConnection(): void
    {
        try {
            Redis::connection('cache')->ping();
        } catch (\Exception) {
            throw new RedisException();
        }
    }

}
