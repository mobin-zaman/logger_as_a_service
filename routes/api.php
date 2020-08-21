<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login','JWTAuthController@login')->name('auth.login') ;
    Route::post('register', 'JWTAuthController@register')->name('auth.register');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');

});

//Route::apiResource('applications', 'ApplicationController');
Route::group([
    'middleware' => 'api',
    'prefix' => 'applications'
], function($router) {
    Route::post('/', 'ApplicationController@store');
    Route::get('/', 'ApplicationController@index');
    Route::get('/{application}', 'ApplicationController@show');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'logs'
], function($router) {

    Route::get('/{application_id}', 'LogController@index');
    Route::post('/', 'LogController@store')->middleware('throttle:600,1');
    Route::get('/count/{application_id}', 'LogController@get_log_count')->middleware('throttle:600,1');
    Route::get('/{application_id}/{count}', 'LogController@get_latest_logs');
    Route::get('/{application_id}/{id}', 'LogController@get_log_by_id');
});
