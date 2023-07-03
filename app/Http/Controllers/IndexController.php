<?php

namespace App\Http\Controllers;

use Exception;

class IndexController
{
    /**
     * @throws Exception
     */
    public function index()
    {
        phpinfo();
    }
}
