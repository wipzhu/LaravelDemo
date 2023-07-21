<?php

namespace App\Console\Commands;

use App\Libraries\DingDing;
use App\Libraries\WeCom;
use Illuminate\Console\Command;

class DingRobotCmd extends Command
{
//

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:ding-robot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '钉钉自定义机器人';

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
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // =============================================钉钉自定义机器人=============================================
        // 文档地址: https://open.dingtalk.com/document/orgapp/custom-bot-creation-and-installation
        $webHookUrl = DingDing::customRobotMakeUrl();
        $at = [
            'at' => [
                'atMobiles' => [
                    '17633947218'
                ],
//                'atUserIds' => [
//                    'user123'
//                ],
//                'isAtAll' => true
            ],
        ];
        $message = [
            'msgtype' => 'text',
            'text' => [
                'content' => "我就是我, 是不一样的烟火"
            ],
        ];
        $message = [
            'msgtype' => 'link',
            'link' => [
                'messageUrl' => 'https://www.dingtalk.com',
                'title' => '测试链接消息',
                'picUrl' => 'https://gw.alicdn.com/imgextra/i4/O1CN013OYoqp1foK6tig7lJ_!!6000000004053-2-tps-864-168.png',
                'text' => '链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容链接消息的内容',
            ]
        ];
        $message = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => '上海天气',
                'text' => "- 上海天气 \n > 日期：" . date('Y-m-d') . " \n > 32度，阵雨转中雨，西北风1级，空气良89，相对温度73%\n > ![screenshot](https://static01.nyt.com/images/2014/05/25/magazine/25wmt/mag-25WMT-t_CA0-master1050.jpg)\n > ###### 10点20分发布 [天气预报](https://www.dingtalk.com) \n"
            ]
        ];
        $message = [
            "msgtype" => "actionCard",
            "actionCard" => [
                "title" => "乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身",
                "text" => "![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png)
                	### 乔布斯 20 年前想打造的苹果咖啡厅
                	Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                "btnOrientation" => "0",
                "singleTitle" => "阅读全文",
                "singleURL" => "https://www.dingtalk.com/"
            ]
        ];
        $message = [
            "msgtype" => "actionCard",
            "actionCard" => [
                "title" => "我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身",
                "text" => "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                "btnOrientation" => "1",//横向排列
                "btns" => [
                    [
                        "title" => "内容不错",
                        "actionURL" => "https://www.dingtalk.com/"
                    ],
                    [
                        "title" => "不感兴趣",
                        "actionURL" => "https://www.baidu.com/"
                    ]
                ]
            ]
        ];
        $message = [
            "msgtype" => "feedCard",
            "feedCard" => [
                "links" => [
                    [
                        "title" => "时代的火车向前开1",
                        "messageURL" => "https://www.dingtalk.com/",
                        "picURL" => "https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png"
                    ],
                    [
                        "title" => "时代的火车向前开2",
                        "messageURL" => "https://www.dingtalk.com/",
                        "picURL" => "https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png"
                    ]
                ]
            ]
        ];


        $data = array_merge($at, $message);
        $res = curlPostJson($webHookUrl, $data);
        dd($res);

    }

}
