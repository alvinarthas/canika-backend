<?php

use Illuminate\Http\Request;

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
// API USER
    // User Login
    Route::post('/user-login', 'UserController@user_login');
    // User update last active
    Route::post('/user-active', 'UserController@user_active');
    // test
    Route::get('/user-test', 'UserController@test');

// API NOTIFIKASI
    // User Notif
    Route::get('/user-notif', 'UserController@user_notif');
    // Read Notif
    Route::post('/notif-read', 'UserController@read_notif');

// API CUSTOMER
    // Get All Customer
        Route::get('/customer-all','CustomerController@index');
    // REGISTER
        Route::post('/customer-register', 'CustomerController@customer_register');
    // LOGIN
        Route::post('/customer-login', 'CustomerController@customer_login');
    // FORGET PASSWORD
        Route::post('/customer-forgetpass', 'CustomerController@forget_password_link');
    // RESET PASSWORD
        Route::post('/customer-resetpass', 'CustomerController@reset_password_link');
    // VIEW PROFILE & EDIT
        Route::get('/customer-profile/{id}', 'CustomerController@customer_profile');
    // UPDATE PROFILE
        Route::put('/customer-update', 'CustomerController@customer_update');
    // UPDATE EMAIL
        Route::put('/customer-email', 'CustomerController@email_update');
    // Customer Email Verification
        Route::get('/customer-verify/{email}/{verifyToken}', 'CustomerController@customer_verify')->name('customerVerify');
    
// API VENDOR
    // ALL VENDOR
        Route::get('/vendor-all', 'VendorController@index');
    // REGISTER
        Route::post('/vendor-register', 'VendorController@vendor_register');
    // LOGIN AS VENDOR
        Route::post('/vendor-login', 'VendorController@vendor_login');
    // RESET PASSWORD
        Route::post('/vendor-resetpass', 'VendorController@reset_password_link');
    // VIEW PROFILE VENDOR
        Route::get('/vendor-profile/{id}', 'VendorController@vendor_profile');
    // UPDATE VENDOR
        Route::put('/vendor-update', 'VendorController@vendor_update');
    // EMAIL VERIFICATION
        Route::get('/vendor-verify/{email}/{verifyToken}', 'VendorController@vendor_verify')->name('vendorVerify');
    // SMS VERIFICATION
        Route::get('/vendor-sms','VendorController@vendor_sms');
    // FORGET PASSWORD
        Route::get('/vendor-forgetpass','VendorController@forget_password_link');
    // Get Barang
        Route::get('/vendor-barang','VendorController@get_barang');
    // Vendor by Category
        Route::get('/vendor-category/{id}','VendorController@vendor_category');
    // Vendor Search
        Route::post('/vendor-search','VendorController@vendor_search');
    // Vendor Popular
        Route::get('/vendor-popular','VendorController@vendor_popular');
    // Vendor Filter
        Route::post('/vendor-filter','VendorController@vendor_filter');
    // Vendor Show Ongoing Transaction & History
        Route::get('/vendor-trx','VendorController@vendor_trx');
    // Vendor Show Detail Transaction
        Route::get('/vendor-detailtrx','VendorController@vendor_detailtrx');
    // Vendor Approve Payment
        Route::put('/vendor-approvepayment','PaymentController@vendor_approvepayment');

// API KATEGORI
    //  API RESOURCES (create,store,update,delete,show)
        Route::apiResource('kategori', 'API\KategoriController');
// API BARANG/JASA
    //  API RESOURCES (create,store,update,delete,show)
        Route::apiResource('barang', 'API\BarangController');
        // JENIS BARANG
        Route::get('/jenis-all', 'API\BarangController@jenis');
        // LOAD BASED ON CATEGORY
        Route::get('/barang-category/{jenis}/{id}','API\BarangController@barang_category');
        Route::post('/barang-search','API\BarangController@search');
        // Popular
        Route::get('/barang-popular/{customer}','API\BarangController@popular');
        Route::delete('/gallery-delete','API\BarangController@gallery_delete');

// API NEGO HARGA
    Route::post('/nego-store', 'NegoController@store');
    Route::get('/nego-all', 'NegoController@index');
    Route::get('/nego-check', 'NegoController@check');
    Route::get('/nego-detail/{id}', 'NegoController@detail');
    // Route::put('/nego-approve', 'NegoController@approve');

// API TRX
    // Wishlist
    Route::get('/wishlist-all/{id}', 'TransaksiController@wishlist_all');
    Route::post('/wishlist-store', 'TransaksiController@wishlist_store');
    Route::post('/wishlist-filter', 'TransaksiController@wishlist_filter');
    Route::delete('/wishlist-delete', 'TransaksiController@wishlist_delete');

    // Transaksi Awal
    Route::get('/trx-customer', 'TransaksiController@list_customer');
    Route::get('/trx-history', 'TransaksiController@history');
    Route::get('/trx-detail/{id}', 'TransaksiController@detail');
    Route::post('/trx-store', 'TransaksiController@store');
    Route::post('/trx-payment', 'TransaksiController@payment');
    Route::put('/trx-delete/{id}', 'TransaksiController@delete');
    Route::get('/trx-awal', 'TransaksiController@awal');

    // Transaksi History
    Route::get('/trxhistory-all/{id}', 'TransaksiController@trxhistory_all');
    Route::post('/trxhistory-status', 'TransaksiController@trxhistory_status');
    Route::put('/trxhistory-update', 'TransaksiController@trxhistory_update');
    Route::delete('/trxhistory-delete/{id}', 'TransaksiController@trxhistory_delete');

// API RATING
    Route::post('/rating-store', 'KomentarController@rating_store');
// API KOMENTAR
    Route::get('/komentar-all/{id}', 'KomentarController@index');
    Route::post('/komentar-store', 'KomentarController@store');
    Route::put('/komentar-update', 'KomentarController@update');
    Route::delete('/komentar-delete/{id}', 'KomentarController@delete');
// API BANK & REKENING 
    // Bank
        Route::get('/bank-all','BankController@bank_all');
        Route::get('/bank-show/{id}','BankController@bank_show');
        Route::post('/bank-store','BankController@bank_store');
        Route::put('/bank-update','BankController@bank_update');
        Route::delete('/bank-delete/{id}','BankController@bank_delete');

    // Rekening
        Route::get('/rekening-all','BankController@rekening_all');
        Route::get('/rekening-show/{id}','BankController@rekening_show');
        Route::post('/rekening-store','BankController@rekening_store');
        Route::put('/rekening-update','BankController@rekening_update');
        Route::delete('/rekening-delete/{id}','BankController@rekening_delete');
// API PAYMENT
    Route::get('/payment-awal','PaymentController@awal');
    Route::get('/payment-check','PaymentController@check');
    Route::get('/payment-konfirmasi','PaymentController@konfirmasi');
    Route::post('/payment-bank','PaymentController@payment_bank');
    Route::put('/payment-upload','PaymentController@payment_upload');
// API KETERANGAN PAYMENT
    Route::get('/keterangan-payment','PaymentController@keterangan_payment');
// API FREEZE
    Route::get('/user-freeze','FreezeController@user_freeze');
    Route::get('/user-ban','FreezeController@user_ban');
    Route::put('/status-update','FreezeController@status_update');
// API REPORT
    Route::get('/user-report','FreezeController@user_report');
    Route::get('/report-detail','FreezeController@report_detail');
    Route::put('/report-update','FreezeController@report_update');
// API SUBSCRIBE
    Route::get('/subscribe-all','SubscribeController@all');