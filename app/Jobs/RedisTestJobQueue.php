<?php

namespace App\Jobs;

use App\Traits\LogTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisTestJobQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, LogTrait;

    protected $redis_key;
    protected $timestamp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($redis_key, $timestamp)
    {
        $this->redis_key = $redis_key;
        $this->timestamp = $timestamp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $r = Redis::rPop($this->redis_key);
            output(time() . '===' . $this->timestamp . '---' . $r);
        } catch (\RedisException $e) {
            Log::error($e->getTraceAsString());
        }
    }
}
