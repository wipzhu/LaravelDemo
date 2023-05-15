<?php

namespace App\Http\Controllers;

use Exception;

class TestController extends Controller
{
    /**
     * @throws Exception
     */
    public function wipzhu()
    {
        phpinfo();
    }

}
