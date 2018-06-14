<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/',function(){
        return redirect('/admin/mcinfo');
    });
    $router->resource('/mcinfo', MCInfoController::class);
    $router->resource('/scripts', ScriptController::class);
    //序列号生成
    $router->get('/serials/generate', 'MCController@index');
    $router->post('/serials/generate', 'MCController@store');
    //充值
    $router->get('/recharge', 'RechargeController@index');
    $router->post('/recharge', 'RechargeController@store');
    //续费
    $router->get('/renewal/{id}', 'RechargeController@renewalIndex');
    $router->post('/renewal', 'RechargeController@renewalStore');
    //Facebook模块
    $router->get('/facebook', 'FacebookController@index');
    $router->post('/facebook', 'FacebookController@store');

});
