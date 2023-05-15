<?php

namespace App\Console\Commands;

use App\Jobs\RenderVideoJob;
use App\Models\Video;
use Illuminate\Console\Command;

class RenderVideoCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:render-video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render Video';

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
     * @return true
     */
    public function handle()
    {
        $video = Video::first();
        RenderVideoJob::dispatch($video)->onQueue('test_queue');
        return true;
    }
}
