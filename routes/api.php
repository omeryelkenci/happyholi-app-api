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

Route::group(['namespace' => 'Api', 'middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function () {
       Route::get('login', 'AuthController@login')->name('api.login');
       Route::post('register', 'AuthController@register')->name('api.register');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('place', 'PlaceController');
        Route::apiResource('post', 'PostController');
    });
});
