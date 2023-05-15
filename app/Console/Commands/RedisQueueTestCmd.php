<?php

namespace App\Console\Commands;

use App\Jobs\RedisQueueTestJob;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisQueueTestCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:redis-queue-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis队列测试';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws Exception
     */
    public function handle()
    {
        $redisKey = 'Test_wipzhu';
//        $redis = MRedis::getInstance();
//        $redis->lpush($redisKey, getRandStr(16));
        Redis::lpush($redisKey, getRandStr(16));

        $delaySeconds = random_int(2, 10);
        RedisQueueTestJob::dispatch($redisKey)->delay($delaySeconds)->onQueue("test_queue");

        return true;
    }
}
