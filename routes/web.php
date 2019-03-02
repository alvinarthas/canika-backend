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
// HOME    
Route::get('/admin/home','WebHome@index')->name('getHome');
Route::post('login','WebHome@login')->name('Login');

Route::group(['prefix' => 'admin', 'middleware' => ['checkAdmin']], function(){
    // ADMIN
    Route::get('logout','WebHome@logout')->name('Logout');

    // CUSTOMER
    Route::get('customer','WebCustomer@index')->name('getCustomer');
    Route::get('customer/create','WebCustomer@create')->name('createCustomer');
    Route::get('customer/store','WebCustomer@store')->name('storeCustomer');
    Route::get('customer/edit/{id}','WebCustomer@edit')->name('editCustomer');
    Route::put('customer/update/{id}','WebCustomer@update')->name('updateCustomer');

    // VENDOR
    Route::get('vendor','WebVendor@index')->name('getVendor');
    Route::get('vendor/create','WebVendor@create')->name('createVendor');
    Route::get('vendor/store','WebVendor@store')->name('storeVendor');
    Route::get('vendor/edit/{id}','WebVendor@edit')->name('editVendor');
    Route::put('vendor/update/{id}','WebVendor@update')->name('updateVendor');

    // BANK
    Route::get('bank','WebBank@index')->name('getBank');

    // REKENING
    Route::get('rekening','WebRekening@index')->name('getRekening');

    // SUBSCRIBE
    Route::get('subscribe','SubscribeController@index')->name('getSubscribe');

    // KATEGORI
    Route::get('kategori','WebKategori@index')->name('getKategori');
    // TRANSAKSI
    Route::get('transaksi','WebTransaksi@index')->name('getTransaksi');
    Route::post('showhistory','WebTransaksi@showhistory')->name('showHistory');

    // PAYMENT
    Route::get('pembayaran','WebPayment@index')->name('getPayment');
    Route::get('approvepayment/{payment}/{trx}/{dp}','WebPayment@approvepayment')->name('approvePayment');
});

Route::post('/subscribe','SubscribeController@subscribe')->name('subscribe');

Route::get('verify/{email}/{verifyToken}','UserController@sendEmailDone')->name('sendEmailDone');