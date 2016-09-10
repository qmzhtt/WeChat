<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::any('wx',"WxController@index");

Route::get('login','UserController@login');
Route::get('logout','UserController@logout');
Route::get('center','UserController@center');

Route::get('/','ShopController@index');
Route::get('goods/{id}','ShopController@goods');

Route::get('cart','ShopController@cart');
Route::get('buy/{id}','ShopController@buy');
Route::get('clear','ShopController@clear');

Route::post('order','ShopController@order');
Route::get('pay','ShopController@pay');
Route::post('payok','ShopController@payok'); 

