<?php

namespace App\Libraries;

use Laravel\SerializableClosure\Signers\Hmac;

class DingDing
{
    private static string $webHookUrl = 'https://oapi.dingtalk.com/robot/send';

    /**
     * @desc: 钉钉自定义机器人url
     * @user: wipzhu
     * @datetime: 2023/7/20 17:58
     * @return string
     */
    public static function customRobotMakeUrl(): string
    {
        $timestamp = get_millisecond();
        $params = [
          	'access_token' => env('DING_CUSTOM_ROBOT_TOKEN', ''),
          	'sign' => self::customRobotMakeSign($timestamp),
          	'timestamp' => $timestamp,
        ];
        $queryStr = build_query($params);

        return self::$webHookUrl . '?' . $queryStr;
    }

    /**
     * @desc: 钉钉自定义机器人签名
     * @user: wipzhu
     * @datetime: 2023/7/20 17:12
     * @param $timestamp
     * @return string
     */
    public static function customRobotMakeSign($timestamp): string
    {
        $secret = env('DING_CUSTOM_ROBOT_SECRET', '');
        // 格式：毫秒数+"\n"+密钥
        $stringToSign = $timestamp . "\n" . $secret;
        // 进行加密操作 并输出二进制数据
        $sign = hash_hmac('sha256', $stringToSign, $secret, true);
        // 加密后进行base64编码 以及url编码
        return urlencode(base64_encode($sign));
    }

}
