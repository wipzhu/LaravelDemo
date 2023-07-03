<?php

namespace App\Jobs;

use App\Traits\LogTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Predis\Client AS Redis;

class RedisQueueTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, LogTrait;

    protected string $redis_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($redis_key)
    {
        $this->redis_key = $redis_key;
    }

    /**
     * 获取应该分配给任务的标记
     *
     * @return array
     */
    public function tags()
    {
        return ['test', $this->redis_key];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $redis = new Redis();
            while ($r = $redis->rpop($this->redis_key)){
                $this->info($r);
            }
        } catch (\RedisException $e) {
            Log::error($e->getTraceAsString());
        }
    }
}
