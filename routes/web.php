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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('index');

Route::group(['prefix' => 'game', 'as' => 'game.'], function () {
    Route::get('/', 'GameController@index')->name('index');
//    Route::get('/', 'GameController@rejectWin')->name('reject_win');
});
