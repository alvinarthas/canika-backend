<?php

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
    return view('welcome');
});

Route::post('/subscribe','SubscribeController@subscribe')->name('subscribe');

Route::get('verify/{email}/{verifyToken}','UserController@sendEmailDone')->name('sendEmailDone');