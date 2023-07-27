<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


$wwwDomain = env('APP_DOMAIN_WWW');

Route::domain($wwwDomain)->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/', [IndexController::class, 'index']);
    Route::get('/test/wipzhu', [TestController::class, 'wipzhu']);

});
