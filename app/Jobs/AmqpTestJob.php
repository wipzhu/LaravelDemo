<?php

namespace App\Jobs;

use App\Traits\LogTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AmqpTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, LogTrait;

    protected array $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * 获取应该分配给任务的标记
     *
     * @return array
     */
    public function tags()
    {
        return ['test', 'amqp-queue-test'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("Amqp Info => " . json_encode($this->msg, JSON_UNESCAPED_UNICODE));
    }
}
