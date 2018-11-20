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


Route::get('/', 'MainController@index')->name('main');
Route::post('/check_voucher', 'MainController@check_voucher');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/new_portal','HomeController@portal_request')->middleware('auth');
Route::post('/new_portal','RequestController@portal_request_update')->middleware('auth');

Route::group(['prefix' => 'wallet', 'middleware' => ['auth','wallet']], function () {
    
    Route::get('','WalletPanelController@index');
    Route::get('dashboard','WalletPanelController@index');
    
    Route::get('users','WalletPanelController@users');
    Route::get('users/{id}','WalletPanelController@user');
    Route::get('users/{id}/edit','WalletPanelController@user_edit');
    Route::get('/users_dt_ajax', 'WalletPanelController@user_dtajax');    
    
    Route::get('reseller','WalletPanelController@reseller');
    
    Route::get('vouchers','WalletPanelController@index');
    Route::get('/voucher/{ids}','WalletPanelController@voucher_print');
    Route::get('/voucher/{id}/row','WalletPanelController@voucher_print_rfresh');
    Route::get('/voucher/{id}/sold','WalletPanelController@voucher_sold');
    Route::get('/voucher/{id}/refund','WalletPanelController@voucher_refund');
    Route::get('/vouchers','WalletPanelController@voucher_list');    
    Route::get('/vouchers_dt_ajax', 'WalletPanelController@dtajax');
    
    Route::get('/vouchers/{action}/{ids}','WalletPanelController@vouchers_actions');
    Route::get('/vouchers/{action}/{ids}','WalletPanelController@vouchers_actions');
    Route::get('/vouchers/{action}/{ids}','WalletPanelController@vouchers_actions');
    
});

Route::group(['prefix' => 'portalpanel', 'middleware' => ['auth','portal_wallet']], function () {
    
    Route::get('','PortalPanelController@index');
    Route::get('dashboard','PortalPanelController@index');
    Route::get('portal/edit','PortalPanelController@edit');
    Route::post('portal/update/{portal_id}','PortalPanelController@update');    
        
    Route::get('/vouchers','PortalPanelController@voucher_list');    
    Route::get('/vouchers_dt_ajax', 'PortalPanelController@dtajax');
    
    Route::get('/apikey/{portal_id}', 'ApiKeyController@get_key_portal');
    Route::get('/apikey/{portal_id}/change', 'ApiKeyController@change_key_portal');
    
});

Route::group(['prefix' => 'adminpanel', 'middleware' => ['auth','admin_wallet']], function () {
    
    Route::get('','WalletAdminPanelController@index');
    Route::get('dashboard','WalletAdminPanelController@index');
    
    Route::resource('roles','RoleController');
    Route::get('/roles_dt_ajax', 'RoleController@dtajax');
    
    Route::resource('resellers','ResellerController');
    Route::get('/resellers_dt_ajax', 'ResellerController@dtajax');
    Route::get('/resellers_dt_ajax/{id}', 'UserController@dtajax_reseller');
    
    Route::resource('voucherprice','VoucherTypeController');
    Route::get('/voucherprice_dt_ajax', 'VoucherTypeController@dtajax');
    
    Route::resource('users','UserController');
    Route::get('/user_dt_ajax', 'UserController@dtajax');    
    
    Route::resource('vouchers','VoucherController');
    Route::get('/voucher/{id}','VoucherController@voucher_show');
    Route::get('/vouchers_dt_ajax', 'VoucherController@dtajax');
    
    Route::get('/apikey/{portal_id}', 'ApiKeyController@get_key');
    Route::get('/apikey/{portal_id}/change', 'ApiKeyController@change_key');
    
    Route::resource('settings','SettingsController');
    Route::get('/settings_portal','SettingsController@portal_settings');    
    
    Route::get('/requests/portal','RequestController@portal_index');  
    Route::get('/requests/portal/{id}','RequestController@portal_show'); 
    Route::get('/requests/portal/{id}/approve','RequestController@portal_approve');     
    Route::get('/requests/portal/{id}/disable','RequestController@portal_disable');     
    Route::delete('/requests/portal/{id}','RequestController@portal_delete');     
    Route::get('/requests/portal_dt_ajax', 'RequestController@portal_dtajax');
            
    Route::resource('portal','PortalController');    
    Route::get('/portal_dt_ajax', 'PortalController@dtajax');
    Route::get('/portal/{id}/disable', 'PortalController@disable');            
        
});