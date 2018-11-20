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

Route::middleware('wallet_api')->post('/activate', 'API\ResourcesController@activate');
Route::middleware('wallet_api')->post('/get_price', 'API\ResourcesController@price_list');
