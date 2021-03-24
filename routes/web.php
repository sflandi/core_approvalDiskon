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


Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@slash');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/om', 'HomeController@om');
Route::get('/kacab', 'HomeController@kacab');
Route::get('/direktur', 'HomeController@direktur');

Route::post('/approveOm/{query}', 'HomeController@storeApprovalOm');
Route::post('/approveKacab/{query}', 'HomeController@storeApprovalKacab');
Route::post('/approveDirektur/{query}', 'HomeController@storeApprovalDirektur');


Route::get('/sendFcm', 'HomeController@sendFcm');
Route::get('/send', 'HomeController@sendNotification');
Route::get('/sendArray', 'HomeController@sendArrayNotification');


// Route::get('/{query}', function($query){
//     if ( md5('gadingserpong') == $query) {
//         $data = 'gadingserpong'; //453ddc459e19801689e4a881f5214494
//     } elseif (md5('greengarden') == $query) {
//         $data = 'greengarden'; //84c98605c766e39fe1c25f4bdcf6f55a
//     } elseif (md5('bandung') == $query) {
//         $data = 'bandung'; //938b4263f09b8b1dae8f027d06681ec9
//     } elseif (md5('citeureup') == $query) {
//         $data = 'citeureup'; //6acb29721a5eb50e3554878ef4e93191
//     } elseif (md5('tendean') == $query) {
//         $data = 'tendean'; //d9bdaa51ceb5d425768c1d80e9103244
//     } elseif (md5('pemuda') == $query) {
//         $data = 'pemuda'; //9fadbc6cae09b4bdd0453762d914b72f
//     } elseif (md5('kyaitapa') == $query) {
//         $data = 'kyaitapa'; //41e6059f81913f46f79dd56646732d23
//     }  else {
//         $data = 'not plaza';
//     }
    
//     // $data = md5($query) ;
//     return $data;
// });

Route::get('/{query}', 'Home2Controller@index');

