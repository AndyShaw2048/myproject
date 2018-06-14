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

Route::post('/mcinfo','MCController@multiedit');
Route::get('/mcinfo/{kind}/{id?}','MCController@getMCInfo')->where('id','[0-9]+');

Route::get('/register','RegisterController@index');
Route::post('/register','RegisterController@store');

Route::post('/mcinfo/kind','MCController@setKind');

Route::get('/facebook/{id?}','FacebookController@getInfo')->where('id','[0-9]+');