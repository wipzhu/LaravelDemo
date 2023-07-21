<?php

namespace App\Libraries;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Predis\Client as Redis;

class WeCom
{
    private static string $webHookUrl = "https://qyapi.weixin.qq.com/cgi-bin/webhook/send";
    private static string $uploadUrl = "https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media";

    /**
     * @desc: 企业微信自定义机器人url
     * @user: wipzhu
     * @datetime: 2023/7/21 14:27
     * @return string
     */
    public static function customRobotMakeUrl(): string
    {
        $key = env('WECOM_CUSTOM_ROBOT_KEY', '');
        return self::$webHookUrl . "?key=" . $key;

    }

    /**
     * @desc: 企业微信自定义机器人上传文件
     * @user: wipzhu
     * @datetime: 2023/7/21 14:27
     * @param string $filePath
     * @return string
     * @throws Exception
     */
    public static function customRobotUploadFile(string $filePath = ''): string
    {
        try {
            $key = env('WECOM_CUSTOM_ROBOT_KEY', '');
            $uploadUrl = self::$uploadUrl . "?type=file&key=" . $key;
            if (!file_exists($filePath) || !is_readable($filePath)) {
                throw new \InvalidArgumentException('文件不存在或文件不可读');
            }

            $file_hash = hash_file('sha256', $filePath);
            $redisKey = "robot_media:". $file_hash;

            $redis = new Redis();
            $media_id = $redis->get($redisKey);
            if ($media_id) {
                return $media_id;
            }

            $filepathArr = explode('/', $filePath);
            $filename = end($filepathArr);

            $response = (new Client())->post($uploadUrl, [
                RequestOptions::MULTIPART => [
                    [
                        'name' => 'media',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => $filename,
                        'filelength' => filesize($filePath)
                    ]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if ($result['errcode'] == 0) {
                // 存入redis，3天过期
                $redis->set($redisKey, $result['media_id']);
                $redis->expireat($redisKey, $result['created_at'] + 86400 * 3);

                return $result['media_id'];
            } else {
                throw new Exception("文件上传失败：" . $result['errmsg']);
            }
        } catch (GuzzleException $e) {
            echo "请求出现错误 " . $e->getMessage() . PHP_EOL;
            exit();
        }
    }

}
