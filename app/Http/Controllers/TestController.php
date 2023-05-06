<?php

namespace App\Http\Controllers;

use App\Jobs\RedisTestJobQueue;
use App\Libraries\MRedis;
use  App\Models\Video;
use App\Jobs\RenderVideo;
use Illuminate\Support\Facades\Redis;
use RedisException;

class TestController extends Controller
{
    /**
     * @throws \Exception
     */
    public function wipzhu()
    {
//        $video = Video::first();
//        RenderVideo::dispatch($video)->onQueue('test-queue')->delay(2);

        $redisKey = 'Test_wipzhu';
//        $redis = MRedis::getInstance();
//        $redis->lpush($redisKey, getRandStr(16));
        Redis::lpush($redisKey, getRandStr(16));
        $timestamp = time();

        $delaySeconds = random_int(2, 10);
        RedisTestJobQueue::dispatch($redisKey, $timestamp)->delay($delaySeconds)->onQueue("test_queue");
    }

}
