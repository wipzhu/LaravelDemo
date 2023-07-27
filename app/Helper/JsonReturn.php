<?php

namespace App\Helper;

class JsonReturn
{
    public static function success($data = [], $message = 'success')
    {
        return response([
            'code' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function fail($message = 'error', $data = [])
    {
        return response([
            'code' => 400,
            'message' => $message,
            'data' => $data
        ]);
    }

}
