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
//Route::post('/amazon','MCController@multiedit');
//Route::get('/amazon/{id?}','MCController@getMCInfo')->where('id','[0-9]+');
//Route::post('/amazon/multiCharge','MCController@multiCharge');

Route::post('/amazonThr','AmazonThrController@multiedit');
Route::get('/amazonThr/{id?}','AmazonThrController@getInfo')->where('id','[0-9]+');
Route::post('/amazonThr/multiCharge','AmazonThrController@multiCharge');

Route::post('/facebook','FacebookController@multiedit');
Route::get('/facebook/{id?}','FacebookController@getInfo')->where('id','[0-9]+');
Route::post('/facebook/multiCharge','FacebookController@multiCharge');

Route::post('/messenger','MessengerController@multiedit');
Route::get('/messenger/{id?}','MessengerController@getInfo')->where('id','[0-9]+');
Route::post('/messenger/multiCharge','MessengerController@multiCharge');

Route::post('/wish','WishController@multiedit');
Route::get('/wish/{id?}','WishController@getInfo')->where('id','[0-9]+');
Route::post('/wish/multiCharge','WishController@multiCharge');

Route::post('/whatsapp','WhatsappController@multiedit');
Route::post('/whatsapp/multiCharge','WhatsappController@multiCharge');
Route::get('/whatsapp/{id?}','WhatsappController@getInfo')->where('id','[0-9]+');

Route::post('/line/multiCharge','LineController@multiCharge');

Route::post('/amazon2','AmazonController@multiedit');
Route::get('/amazon2/{id?}','AmazonController@getInfo')->where('id','[0-9]+');
Route::post('/amazon2/multiCharge','AmazonController@multiCharge');

Route::post('/instagram','InstagramController@multiedit');
Route::get('/instagram/{id?}','InstagramController@getInfo')->where('id','[0-9]+');
Route::post('/instagram/multiCharge','InstagramController@multiCharge');

Route::post('/invitation','InvitationController@generate');