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

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/register','RegisterController@index');
Route::post('/register','RegisterController@store');

//模块信息管理
Route::post('/amazon','MCController@multiedit');
Route::get('/amazon/{id?}','MCController@getMCInfo')->where('id','[0-9]+');

Route::post('/facebook','FacebookController@multiedit');
Route::get('/facebook/{id?}','FacebookController@getInfo')->where('id','[0-9]+');

Route::post('/messenger','MessengerController@multiedit');
Route::get('/messenger/{id?}','MessengerController@getInfo')->where('id','[0-9]+');

Route::post('/wish','WishController@multiedit');
Route::get('/wish/{id?}','WishController@getInfo')->where('id','[0-9]+');


