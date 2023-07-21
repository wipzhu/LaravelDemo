<?php

namespace App\Console\Commands;

use App\Libraries\DingDing;
use App\Libraries\WeCom;
use Illuminate\Console\Command;

class WipzhuTestCmd extends Command
{
//

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:wipzhu-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wipzhu测试专用脚本';

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
     */
    public function handle()
    {
        $s = "Hello World";
        $this->line($s);
        $this->comment($s);
        $this->info($s);
        $this->question($s);
        $this->warn($s);
        $this->error($s);
    }

}
