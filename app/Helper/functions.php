<?php
/**
 * @param $msg
 * @param bool $showTime
 * @param bool $isCli
 */
function output($msg, $showTime = true, $isCli = true): void
{
    echo ($showTime ? '[' . date('Y-m-d H:i:s') . '] ' : '') . $msg . ($isCli ? PHP_EOL : '<br/>');
}

/**
 * @param $msg
 * @param string $uuid
 * @param bool $showTime
 * @param bool $isCli
 */
function outputWithUuid($msg, string $uuid = '', bool $showTime = true, bool $isCli = true): void
{
    $msg = empty($uuid) ? $msg : $msg . ':' . $uuid;
    output($msg, $showTime, $isCli);
}

/**
 * 检测是否为邮箱
 * @param $text
 * @return bool
 */
function isEmail($text): bool
{
    return preg_match('/^\w+([\-.]\w+)*@\w+([\-.]\w+)*$/', trim($text));
}

/**
 * 检测是否为手机
 * @param $text
 * @return bool
 */
function isMobile($text): bool
{
    return preg_match('/^1[3|4|5|6|7|8|9]\d{9}$/', trim($text));
}

/**
 * 给手机或邮箱加***
 * @param $text
 * @param string $type
 * @return bool|string
 */
function replaceStar($text, string $type = 'mobile'): bool|string
{
    if ($type == 'email' && isEmail($text)) {
        $input = explode('@', $text);
        $len = strlen($input[0]);
        $end = $len <= 3 ? 1 : 3;
        return substr($input[0], 0, $end) . '****@' . $input[1];
    } elseif ($type == 'mobile' && isMobile($text)) {
        $map['mobile'] = trim($text);
        return substr($map['mobile'], 0, 3) . "*****" . substr($map['mobile'], 7, 4);
    }
    return $text;
}

/**
 * @desc 格式化输出调试信息
 * @param $arr
 * @author wipzhu
 * @update unknown
 */
function pr($arr): void
{
    if (is_array($arr) || is_object($arr)) {
        if (!empty($arr)) {
            echo "<pre>";
            print_r($arr);
            echo "<pre/>";
        } else {
            echo "pr数组为空";
        }
    } else {
        echo "<pre>";
        var_dump($arr);
        echo "<pre/>";
    }
}

/**
 * @desc 获取随机字符串
 * @param $length
 * @return string
 * @author wipzhu
 * @update unknown
 */
function getRandomStr($length): string
{
    //字符组合
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($str) - 1;
    $randStr = '';
    for ($i = 0; $i < $length; $i++) {
        $num = mt_rand(0, $len);
        $randStr .= $str[$num];
    }
    return $randStr;
}

/**
 * @desc 导出到csv文件
 * @param $data
 * @param $title
 * @param $filename
 * @param string $savePath
 * @author wipzhu
 * @update unknown
 */
function exportCsv($data, $title, $filename, string $savePath = '../data/exportFile/'): void
{
    // 判断保存目录是否存在 不存在就创建
    if (!is_dir($savePath)) {
        mkdir($savePath, 0777, true);
    }
    array_unshift($data, $title);

    $fullName = $savePath . $filename . '.csv'; //设置文件名

    header("Content-Type: text/csv;charset=utf-8");
    header("Content-Disposition: attachment;filename=\"$fullName\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    $fp = fopen($fullName, 'w');
    // 对于用 wps 和编辑器打开无乱码但是用 excel 打开出现乱码的问题,可以添加以下一行代码解决问题
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
}
