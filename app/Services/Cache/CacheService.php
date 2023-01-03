<?php

namespace App\Services\Cache;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    private Connection $redis;

    public function __construct()
    {
        $this->redis = Redis::connection('cache');
    }

    public function get(string $key)
    {
        return json_decode($this->redis->get($key), true);
    }

    public function set(string $key, string $data, int $ttl = 3600): void
    {
        $this->redis->set($key, $data);
        $this->redis->expire($key, $ttl);
    }
}
