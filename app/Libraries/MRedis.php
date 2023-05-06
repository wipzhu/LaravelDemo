<?php

namespace App\Libraries;

use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;

class MRedis extends Redis
{
    /**
     * 获取Redis门面实例
     * @return RedisManager
     */
    public static function getInstance()
    {
        return self::connection('default');
    }
}
