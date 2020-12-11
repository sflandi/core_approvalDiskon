<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now c    reate something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/sendFcm', 'HomeController@sendFcm');
Route::get('/send', 'HomeController@sendNotification');
Route::get('/sendArray', 'HomeController@sendArrayNotification');


