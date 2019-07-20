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

Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::get('/users/{id}/edit', 'UserController@edit')->name('users.edit')
        ->where('id', '[0-9]+');

    Route::get('/sections', 'SectionController@index')->name('sections');
    Route::get('/sections/create', 'SectionController@create')->name('sections.create');
    Route::get('/sections/{id}/edit', 'SectionController@edit')->name('sections.edit')
        ->where('id', '[0-9]+');

    Route::get('/changeLocale/{locale}', 'LocaleController@change')->name('changeLocale');
});
