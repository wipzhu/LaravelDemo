<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

Trait LogTrait
{
    protected $logPath;

    public function info($msg, $writeType = FILE_APPEND)
    {
        $this->logPath = storage_path('logs/default.log');
        file_put_contents($this->logPath, Carbon::now()->toDateTimeString() . " " . $msg . "\n", $writeType);
    }
}
