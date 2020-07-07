<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return config('broadcasting');
});


Route::get('publish', function () {
    // Route logic...

    Redis::publish('test-channel', json_encode(['foo' => 'bar']));
});


Route::get('/fire', function () {
    event(new \App\Events\TestEvent());
    return 'ok';
});
