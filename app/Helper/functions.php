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
 * @desc: 获取毫秒级时间戳
 * @user: wipzhu
 * @datetime: 2023/7/20 17:35
 * @return string
 */
function get_millisecond(): string
{
    // 获取微秒数时间戳
    $tempTime = explode(' ', microtime());
    // 转换成毫秒数时间戳
    return (float)sprintf('%.0f', (floatval($tempTime[0]) + floatval($tempTime[1])) * 1000);
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

/**
 * AES-CBC 128位加密方案
 * @param $text
 * @param bool $isEncrypt 是否是加密
 * @param bool $key
 * @param bool $iv
 * @param bool $delEqual 是否删除base64之后的==
 * @return string
 */
function AES_128($text, $isEncrypt = true, $key = false, $iv = false, $delEqual = true, $hex = false)
{
    if (empty($text)) {
        return $text;
    }
    $privateKey = $key ?: config("common.aes_key");
    $iv = $iv ?: $privateKey;
    if ($isEncrypt) {//加密
        $encrypted = openssl_encrypt($text, 'AES-128-CBC', $privateKey, OPENSSL_RAW_DATA, $iv);
        $encrypted = $hex ? bin2hex($encrypted) : base64_encode($encrypted);
        return $delEqual ? str_replace('==', '', $encrypted) : $encrypted;
    } else { //解密
        $encryptedData = $hex ? hex2bin($text) : base64_decode($text);
        $decrypted = openssl_decrypt($encryptedData, 'AES-128-CBC', $privateKey, OPENSSL_RAW_DATA, $iv);
        return trim($decrypted);
    }
}

/**
 * AES-CBC 256位加密方案
 * @param $text
 * @param bool $isEncrypt 是否是加密
 * @param bool $key
 * @param bool $iv
 * @param bool $delEqual 是否删除base64之后的==
 * @return string
 */
function AES_256($text, $isEncrypt = true, $key = false, $iv = false, $delEqual = true, $hex = false)
{
    $privateKey = $key ?: config("common.aes_key_256");
    $iv = $iv ?: md5($privateKey, true);
    if ($isEncrypt) {//加密
        $encrypted = openssl_encrypt($text, 'AES-256-CBC', $privateKey, OPENSSL_RAW_DATA, $iv);
        $encrypted = $hex ? bin2hex($encrypted) : base64_encode($encrypted);
        return $delEqual ? str_replace('==', '', $encrypted) : $encrypted;
    } else { //解密
        $encryptedData = $hex ? hex2bin($text) : base64_decode($text);
        $decrypted = openssl_decrypt($encryptedData, 'AES-256-CBC', $privateKey, OPENSSL_RAW_DATA, $iv);
        return trim($decrypted);
    }
}


/**
 * curl get url data
 */
function curlGet($url, $timeout = 20)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'INTERNAL API CHANNEL');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名（为0也可以，就是连域名存在与否都不验证了）

    $file_contents = curl_exec($ch);
    curl_close($ch);
    return urldecode($file_contents);
}

/**
 * curlPost
 * @param string $url
 * @param array $data
 * @param array $header
 * @param int $timeout
 * @param int $maxtimeout
 * @param bool $needDecode
 * @return string
 */
function curlPost($url, $data, $header = [], $timeout = 5, $maxtimeout = 30, $needDecode = TRUE)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'INTERNAL API CHANNEL');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    $post_data = http_build_query($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);// 检查证书中是否设置域名（为0也可以，就是连域名存在与否都不验证了）
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $maxtimeout);
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    //打印获得的数据
    return $needDecode ? urldecode($output) : $output;
}

/**
 * Json参数的Post请求
 * @param $url
 * @param $data
 * @param int $timeout
 * @param int $maxtimeout
 * @return mixed
 */
function curlPostJson($url, $data, $timeout = 5, $maxtimeout = 30)
{
    $dataStr = json_encode($data, JSON_UNESCAPED_UNICODE);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'INTERNAL API CHANNEL');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataStr);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);// 检查证书中是否设置域名（为0也可以，就是连域名存在与否都不验证了）
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $maxtimeout);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=utf-8',
        'Content-Length: ' . strlen($dataStr)
    ));
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

/**
 * 拼接http 请求串
 * @tutorial 模仿 php 的http_build_query($query_data)方法,
 *           但只能处理简单的键名值数组,没有办法处理对象;
 *           做这函数的原因是一个接口中使用http_build_query拼出的结果与接口不一致
 * @param array $query_data 要拼接参数的键名->值数组
 * @param bool $encoding 是否 urlencode 编码(如果是微信,有时不进行编码会无法显示)
 * @return string 拼接完成的字符串(不含 domain?)
 */
function build_query(array $query_data, bool $encoding = false): string
{
    $res = '';
    $count = count($query_data);
    $i = 0;
    foreach ($query_data as $k => $v) {
        if ($encoding === true) {
            $v = urlencode($v);
        }
        if ($i < $count - 1) {
            $res .= $k . '=' . $v . '&';
        } else {
            $res .= $k . '=' . $v;
        }
        $i++;
    }
    return $res;
}
