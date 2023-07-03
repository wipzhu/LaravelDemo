<?php

namespace App\Http\Controllers;

use Exception;

class TestController extends Controller
{
    public function wipzhu()
    {
        $mode = collect([1, 1, 2, 2, 2])->mode();
        dd($mode);
    }

}
