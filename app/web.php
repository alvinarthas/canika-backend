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



Route::get('/','HomeController@index')->name('getHome');

Route::post('login','HomeController@login')->name('Login');

Route::get('/logout', 'HomeController@logout')->name('logout');

Route::get('/employee/add', 'EmployeeController@create');

Route::post('/employee/add', 'EmployeeController@store');



Route::middleware(['checkUser'])->group(function () {

    Route::get('/product/view', 'ProductController@index');

    Route::get('/product/add', 'ProductController@create');

    Route::post('/product/add', 'ProductController@store');

    Route::get('/product/{id}/edit', 'ProductController@edit');

    Route::put('/product/{id}/edit', 'ProductController@update');

    Route::delete('/product/{id}/delete','ProductController@destroy');

    Route::post('/product/import', 'ProductController@import');



    Route::get('/customer/view', 'CustomerController@index');

    Route::get('/customer/add', 'CustomerController@create');

    Route::post('/customer/add', 'CustomerController@store');

    Route::get('/customer/{id}/edit', 'CustomerController@edit');

    Route::put('/customer/{id}/edit', 'CustomerController@update');

    Route::delete('/customer/{id}/delete','CustomerController@destroy');



    Route::get('/sales/view', 'SalesController@index');

    Route::get('/sales/add', 'SalesController@create');

    Route::post('/sales/store', 'SalesController@store');

    Route::get('/sales/{id}/edit', 'SalesController@edit');

    Route::put('/sales/{id}/edit', 'SalesController@update');

    Route::delete('/sales/{id}/delete','SalesController@destroy');



    Route::get('/salesdetail/view', 'SalesdetailController@index');

    Route::get('/salesdetail/add', 'SalesdetailController@create');

    Route::post('/salesdetail/{trx_id}/add', 'SalesdetailController@store');

    Route::get('/salesdetail/{id}/edit', 'SalesdetailController@edit');

    Route::put('/salesdetail/{id}/edit', 'SalesdetailController@update');

    Route::delete('/salesdetail/{id}/delete','SalesdetailController@destroy');

    Route::get('/salesdetail/readdata/','SalesdetailController@readData');



    Route::get('/purchase/view', 'PurchaseController@index');

    Route::get('/purchase/add', 'PurchaseController@create');

    Route::post('/purchase/store', 'PurchaseController@store');

    Route::get('/purchase/{id}/edit', 'PurchaseController@edit');

    Route::put('/purchase/{id}/edit', 'PurchaseController@update');

    Route::delete('/purchase/{id}/delete','PurchaseController@destroy');



    Route::get('/purchasedetail/view', 'PurchasedetailController@index');

    Route::get('/purchasedetail/add', 'PurchasedetailController@create');

    Route::post('/purchasedetail/{trx_id}/add', 'PurchasedetailController@store');

    Route::get('/purchasedetail/{id}/edit', 'PurchasedetailController@edit');

    Route::put('/purchasedetail/{id}/edit', 'PurchasedetailController@update');

    Route::delete('/purchasedetail/{id}/delete','PurchasedetailController@destroy');

    Route::get('/purchasedetail/readdata/','PurchasedetailController@readData');



    Route::get('/payment/view', 'PaymentController@index');

    Route::get('/payment', 'PaymentController@purchaselist');

    Route::get('/payment/{id}/add', 'PaymentController@create');

    Route::post('/payment/store', 'PaymentController@store');

    Route::get('/payment/{id}/edit', 'PaymentController@edit');

    Route::put('/payment/{id}/edit', 'PaymentController@update');

    Route::delete('/payment/{id}/delete','PaymentController@destroy');



    Route::get('/receiveitem', 'StockController@index');

    Route::get('/receiveitem/{id}/update', 'StockController@edit');

    Route::put('/receiveitem/{id}/update', 'StockController@update');

});

