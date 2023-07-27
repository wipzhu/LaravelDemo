<?php

namespace App\Http\Controllers\Api;

use App\Helper\JsonReturn;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function upload(Request $request): ResponseFactory|Application|Response
    {
        $file = $request->file('file');
//        $savePath = $file->store('uploads');
//        $savePath = Storage::putFile('uploads', $file);

        $savePath = $file->storeAs(
            'uploads', $file->getClientOriginalName()
        );
//        $savePath = Storage::putFileAs(
//            'uploads', $file, $file->getClientOriginalName()
//        );

        return JsonReturn::success(['save_path' => $savePath]);
    }
}
