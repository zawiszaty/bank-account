<?php

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

Route::put('account', 'AccountController@create');
Route::post('account/{account}/add/balance', 'AccountController@addToBalance');
Route::post('account/{account}/withdraw', 'AccountController@withdraw');
Route::get('accounts', 'AccountController@getAccounts');
Route::get('account/{account}', 'AccountController@getAccount');
