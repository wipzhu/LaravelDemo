<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RenderVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * video 实例
     *
     * @var Video
     */
    public $video;

    /**
     * 创建一个新的任务实例
     *
     * @param Video $video
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * 获取应该分配给任务的标记
     *
     * @return array
     */
    public function tags()
    {
        return ['render', 'video:' . $this->video->id];
    }

    /**
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
//        echo $this->video->id;

        $data = $this->video->getAttributes();
        Log::info("Video Data ==> " . json_encode($data, JSON_UNESCAPED_UNICODE));

//        $id = $this->video->getAttribute('id');
//        print_r($this->video->getAttribute('id'));
//        info($id);
    }

}
