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

Route::group(['middleware' => 'auth', 'prefix' => '/v1'], function () {

    Route::get('/users/all', 'UserController@all');
    Route::post('/sections/{id}', 'SectionController@update');

    Route::apiResources([
        'users' => 'UserController',
        'sections' => 'SectionController',
    ]);

});
