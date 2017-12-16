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


// Auth::routes();

Route::get('cache', 'HomeController@cacheApis')->name('cache-load');

Route::get('play-random', 'ApiEndpointController@playRandom')->name('play-random');
Route::post('/json/play-random', 'ApiEndpointController@playRandom')->name('play-random-json');

Route::get('/', 'HomeController@index')->name('home');