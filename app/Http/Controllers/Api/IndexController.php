<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $ret = [
            'code' => 200,
            'message' => 'success',
            'data' => [
                'name' => 'wipzhu',
                'age' => 29
            ]
        ];

        return response($ret);
    }
}
