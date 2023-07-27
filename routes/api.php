<?php

use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
$apiDomain = env('APP_DOMAIN_API');
Route::domain($apiDomain)->group(function () {
    Route::get('/', [IndexController::class, 'index']);


    Route::middleware(['throttle:uploads'])->group(function () {
        // 上传限流
        Route::post('/upload', [TestController::class, 'upload'])->name('upload');
    });
});


