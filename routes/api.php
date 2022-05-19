<?php

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

Route::group(['prefix' => '/v1', 'namespace' => 'App\Http\Controllers\Api',], function () {
    Route::get('/token', ['as' => 'token', 'uses' => 'AuthController@login']);
    Route::group(['prefix' => '/users','as'=>'users.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
        Route::post('/', ['as' => 'store', 'middleware' => 'auth:api, jwt.refresh', 'uses' => 'UserController@store']);
        Route::get('/{id}', ['as' => 'show', 'uses' => 'UserController@show']);
    });
    Route::get('/positions', ['as' => 'positions.index', 'uses' => 'PositionController@index']);
});
