<?php

namespace App\Console\Commands;

use App\Jobs\AmqpTestJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AmqpTestCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:amqp-queue-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Amqp测试';

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
     */
    public function handle()
    {
        try {
            $msg = [
                'test_msg' => 'Hello world',
                'name' => 'wipzhu',
                'age' => '28',
                'gender' => 1,
                'address' => '上号',
            ];
            // for ($i=0; $i < 5; $i++) {
            //     $this->dispatch(new Queue($params));
            // }
//            $this->dispatch(new AmqpTestJob($msg));
            AmqpTestJob::dispatch($msg)->onQueue('rabbitMqQueue');

            return true;

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return false;
        }
    }
}
