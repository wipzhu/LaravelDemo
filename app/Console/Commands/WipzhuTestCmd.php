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
        $name = $this->ask('Your username is?');
        $this->info('Your name is：' . $name);

        $password = $this->secret('Your password is?');
        $this->info('Your password is：' . $password);

        $continue = $this->confirm('Do you want to continue?');
        if ($continue) {
            $this->info('yes, continue');
        } else {
            $this->warn('no, break');
        }

        $city = $this->choice('Your city is?', ['Beijing', 'Shanghai', 'Shenzhen']);
        $this->info('Your city is：' . $city);

        $headers = ['name', 'password', 'city'];
        $users = [
            [
                'name' => $name,
                'password' => $password,
                'city' => $city
            ]
        ];
        $this->table($headers, $users);

        // 获取指定参数
        if ($this->hasArgument('name')) {
            // 获取所有参数 $args = $this->arguments()
            $arg = $this->argument('name');
            if (!is_null($arg)) {
                $this->info($arg);
            }
        }
        // 获取指定选项
        if ($this->hasOption('id')) {
            // 获取所有选项 $options = $this->options()
            $option = $this->option('id');
            if (!is_null($option)) {
                $this->info($option);
            }
        }
        die();
        $s = "Hello World";
        $this->line($s);
        $this->comment($s);
        $this->info($s);
        $this->question($s);
        $this->warn($s);
        $this->error($s);
    }

}
