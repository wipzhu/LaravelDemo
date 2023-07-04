<?php

namespace App\Console\Commands;

use App\Jobs\RedisQueueTestJob;
use Exception;
use Illuminate\Console\Command;
use Predis\Client AS Redis;

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
        $redis = new Redis();

        for ($i = 0; $i < 10; $i++) {
            $randomStr = getRandomStr(16);
            output("生成的随机字符串为：" . $randomStr);
            $redis->lpush($redisKey, (array)$randomStr);
        }
        $delaySeconds = random_int(2, 10);
        RedisQueueTestJob::dispatch($redisKey)->delay($delaySeconds)->onQueue("redisQueue");

        return true;
    }
}
