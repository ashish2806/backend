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

Route::post('login',['as'=>'login','uses'=>'API\UserController@login']);
Route::post('register','API\UserController@register');
Route::group(['middleware'=>'auth:api'],function(){
    Route::post('get','API\UserController@getDetails');
});



Route::post('adminlogin',['as'=>'login','uses'=>'API\AdminController@adminlogin']);
Route::post('adminregister','API\AdminController@adminregister');
Route::group(['middleware'=>'auth:api-admin'],function(){
    Route::post('adminget','API\AdminController@admingetDetails');
});
