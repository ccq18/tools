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
// Route::get('toauth', 'Api\AuthController@toauth');

Route::get('login-url', 'Api\AuthController@getLoginUrl');
Route::post('login', 'Api\AuthController@login');
Route::post('logout', 'Api\AuthController@logout');
Route::post('refresh', 'Api\AuthController@refresh');
Route::group(['middleware' => 'jwt.auth',], function () {
    Route::get('toauth', function (){
        return json_response('authed');
    });
});
Route::get('noauth', function (){
    return 'noauth';
});