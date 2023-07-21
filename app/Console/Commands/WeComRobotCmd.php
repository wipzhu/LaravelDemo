<?php

namespace App\Console\Commands;

use App\Libraries\DingDing;
use App\Libraries\WeCom;
use Illuminate\Console\Command;

class WeComRobotCmd extends Command
{
//

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zron:wecom-robot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '企业微信自定义机器人';

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
        // =============================================企业微信自定义机器人发送消息=============================================
        // 文档地址: https://developer.work.weixin.qq.com/document/path/99110
        $webHookUrl = WeCom::customRobotMakeUrl();
        $message = [
            'msgtype' => 'text',
            'text' => [
                'content' => "我就是人见人爱，花见花开，怪兽见了就悲哀的猪猪侠！长得好看的才叫吃货，长得丑的那叫饭桶！",
//                "mentioned_list" => ["wipzhu"],
//                "mentioned_mobile_list" => ["17633947218"]
            ],
        ];
        $message = [
            "msgtype" => "markdown",
            "markdown" => [
                "content" => "实时新增用户反馈<font color=\"warning\">132例</font>，请相关同事注意。\n
                            >类型:<font color=\"comment\">用户反馈</font>
                            >普通用户反馈:<font color=\"red\">117例</font>
                            >VIP用户反馈:<font color=\"warning\">15例</font>"
            ]
        ];

//        $imagePath = storage_path("app/public/ggbond.jpg");
//        $message = [
//            "msgtype" => "image",
//            "image" => [
//                "base64" => base64_encode(file_get_contents($imagePath)),
//                "md5" => md5(file_get_contents($imagePath))
//            ]
//        ];

//        $message = [
//            "msgtype" => "news",
//            "news" => [
//                "articles" => [
//                    [
//                        "title" => "中秋节礼品领取",
//                        "description" => "今年中秋节公司有豪礼相送",
//                        "url" => "https://www.tencent.com/",
//                        "picurl" => "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png"
//                    ]
//                ]
//            ]
//        ];

        // =============================================企业微信自定义机器人上传文件=============================================
        $filePath = storage_path("app/public/ggbond.jpg");
//        $filePath = storage_path("app/public/test.txt");
        $media_id = WeCom::customRobotUploadFile($filePath);
        $message = [
            "msgtype" => "file",
            "file" => [
                "media_id" => $media_id
            ]
        ];
        $message = [
            "msgtype" => "template_card",
            "template_card" => [
                "card_type" => "text_notice",
                "source" => [
                    "icon_url" => "https://wework.qpic.cn/wwpic/252813_jOfDHtcISzuodLa_1629280209/0",
                    "desc" => "企业微信",
                    "desc_color" => ''
                ],
                "main_title" => [
                    "title" => "欢迎使用企业微信",
                    "desc" => "您的好友正在邀请您加入企业微信"
                ],
                "emphasis_content" => [
                    "title" => "100",
                    "desc" => "数据含义"
                ],
                "quote_area" => [
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi",
//                    "appid" => "APPID",
//                    "pagepath" => "PAGEPATH",
                    "title" => "引用文本标题",
                    "quote_text" => "Jack：企业微信真的很好用~\nBalian：超级好的一款软件！"
                ],
                "sub_title_text" => "下载企业微信还能抢红包！",
                "horizontal_content_list" => [[
                    "keyname" => "邀请人",
                    "value" => "张三"
                ], [
                    "keyname" => "企微官网",
                    "value" => "点击访问",
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi"
                ], [
                    "keyname" => "企微下载",
                    "value" => "猪猪侠.jpg",
                    "type" => 2,
                    "media_id" => $media_id
                ]],
                "jump_list" => [[
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi",
                    "title" => "企业微信官网"
                ],
//                    [
//                        "type" => 2,
//                        "appid" => "APPID",
//                        "pagepath" => "PAGEPATH",
//                        "title" => "跳转小程序"
//                    ]
                ],
                "card_action" => [
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi",
                ]
            ]
        ];

        $message = [
            "msgtype" => "template_card",
            "template_card" => [
                "card_type" => "news_notice",
                "source" => [
                    "icon_url" => "https://wework.qpic.cn/wwpic/252813_jOfDHtcISzuodLa_1629280209/0",
                    "desc" => "企业微信",
                    "desc_color" => 3
                ],
                "main_title" => [
                    "title" => "欢迎使用企业微信",
                    "desc" => "您的好友正在邀请您加入企业微信"
                ],
                "card_image" => [
                    "url" => "https://wework.qpic.cn/wwpic/354393_4zpkKXd7SrGMvfg_1629280616/0",
                    "aspect_ratio" => 2.25
                ],
                "image_text_area" => [
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com",
                    "title" => "欢迎使用企业微信",
                    "desc" => "您的好友正在邀请您加入企业微信",
                    "image_url" => "https://wework.qpic.cn/wwpic/354393_4zpkKXd7SrGMvfg_1629280616/0"
                ],
                "quote_area" => [
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi",
//                    "appid" => "APPID",
//                    "pagepath" => "PAGEPATH",
                    "title" => "引用文本标题",
                    "quote_text" => "Jack：企业微信真的很好用~\nBalian：超级好的一款软件！"
                ],
                "vertical_content_list" => [
                    [
                        "title" => "惊喜红包等你来拿",
                        "desc" => "下载企业微信还能抢红包！"
                    ]
                ],
                "horizontal_content_list" => [
                    [
                        "keyname" => "邀请人",
                        "value" => "张三"
                    ],
                    [
                        "keyname" => "企微官网",
                        "value" => "点击访问",
                        "type" => 1,
                        "url" => "https://work.weixin.qq.com/?from=openApi"
                    ],
                    [
                        "keyname" => "企微下载",
                        "value" => "猪猪侠.jpg",
                        "type" => 2,
                        "media_id" => $media_id
                    ]
                ],
                "jump_list" => [
                    [
                        "type" => 1,
                        "url" => "https://work.weixin.qq.com/?from=openApi",
                        "title" => "企业微信官网"
                    ],
//                    [
//                        "type" => 2,
//                        "appid" => "APPID",
//                        "pagepath" => "PAGEPATH",
//                        "title" => "跳转小程序"
//                    ]
                ],
                "card_action" => [
                    "type" => 1,
                    "url" => "https://work.weixin.qq.com/?from=openApi",
//                    "appid" => "APPID",
//                    "pagepath" => "PAGEPATH"
                ]
            ]
        ];

        $res = curlPostJson($webHookUrl, $message);
        dump($res);

        exit();

    }

}
