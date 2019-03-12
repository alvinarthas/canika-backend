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
    Route::get('admins','WebAdmin@index')->name('getAdmin');
    Route::get('admins/create','WebAdmin@create')->name('createAdmin');
    Route::post('admins/store','WebAdmin@store')->name('storeAdmin');
    Route::get('admins/edit/{id}','WebAdmin@edit')->name('editAdmin');
    Route::put('admins/update/{id}','WebAdmin@update')->name('updateAdmin');

    // CUSTOMER
    Route::get('customer','WebCustomer@index')->name('getCustomer');
    Route::get('customer/create','WebCustomer@create')->name('createCustomer');
    Route::post('customer/store','WebCustomer@store')->name('storeCustomer');
    Route::get('customer/edit/{id}','WebCustomer@edit')->name('editCustomer');
    Route::put('customer/update/{id}','WebCustomer@update')->name('updateCustomer');

    // VENDOR
    Route::get('vendor','WebVendor@index')->name('getVendor');
    Route::get('vendor/create','WebVendor@create')->name('createVendor');
    Route::post('vendor/store','WebVendor@store')->name('storeVendor');
    Route::get('vendor/edit/{id}','WebVendor@edit')->name('editVendor');
    Route::put('vendor/update/{id}','WebVendor@update')->name('updateVendor');

    // BANK
    Route::get('bank','WebBank@index')->name('getBank');
    Route::get('bank/create','WebBank@create')->name('createBank');
    Route::post('bank/store','WebBank@store')->name('storeBank');
    Route::get('bank/edit/{id}','WebBank@edit')->name('editBank');
    Route::put('bank/update/{id}','WebBank@update')->name('updateBank');
    Route::delete('bank/delete/{id}','WebBank@destroy')->name('destroyBank');

    // REKENING
    Route::get('rekening','WebRekening@index')->name('getRekening');
    Route::get('rekening/create','WebRekening@create')->name('createRekening');
    Route::post('rekening/store','WebRekening@store')->name('storeRekening');
    Route::get('rekening/edit/{id}','WebRekening@edit')->name('editRekening');
    Route::put('rekening/update/{id}','WebRekening@update')->name('updateRekening');
    Route::delete('rekening/delete/{id}','WebRekening@destroy')->name('destroyRekening');

    // SUBSCRIBE
    Route::get('subscribe','SubscribeController@index')->name('getSubscribe');

    // KATEGORI
    Route::get('kategori','WebKategori@index')->name('getKategori');
    Route::get('kategori/create','WebKategori@create')->name('createKategori');
    Route::post('kategori/store','WebKategori@store')->name('storeKategori');
    Route::get('kategori/edit/{id}','WebKategori@edit')->name('editKategori');
    Route::put('kategori/update/{id}','WebKategori@update')->name('updateKategori');
    Route::delete('kategori/delete/{id}','WebKategori@destroy')->name('destroyKategori');
    // TRANSAKSI
    Route::get('transaksi','WebTransaksi@index')->name('getTransaksi');
    Route::get('transaksi/edit/{id}','WebTransaksi@editTrx')->name('editTransaksi');
    Route::put('transaksi/update/{id}','WebTransaksi@updateTrx')->name('updateTransaksi');
    Route::post('showhistory','WebTransaksi@showhistory')->name('showHistory');

    // PAYMENT
    Route::get('pembayaran','WebPayment@index')->name('getPayment');
    Route::get('approvepayment/{payment}/{trx}/{dp}','WebPayment@approvepayment')->name('approvePayment');
});

Route::post('/subscribe','SubscribeController@subscribe')->name('subscribe');

Route::get('verify/{email}/{verifyToken}','UserController@sendEmailDone')->name('sendEmailDone');