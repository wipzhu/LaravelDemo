<?php

namespace App\Http\Controllers;

use  App\Models\Video;
use App\Jobs\RenderVideo;

class TestController
{
    public function wipzhu()
    {
        $video = Video::first();
        RenderVideo::dispatch($video)->onQueue('test-queue')->delay(2);
    }

}
