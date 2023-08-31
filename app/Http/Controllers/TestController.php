<?php

namespace App\Http\Controllers;

use Exception;
use Wipzhu\MyPhpTools\Tools;

class TestController extends Controller
{
    public function wipzhu()
    {
        Tools::helloWorld();
        $phone = '17633947218';
        $newPhone = Tools::replaceStar($phone);
        Tools::pr($newPhone);

        $res = Tools::checkIdNumber("412726199411074911");
        dump($res);

        die();
        $mode = collect([1, 1, 2, 2, 2])->mode();
        dd($mode);
    }

}
