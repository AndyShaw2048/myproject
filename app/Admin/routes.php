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

    $router->get('/serials/generate', 'MCController@index');
    $router->post('/serials/generate', 'MCController@store');

    $router->get('/recharge', 'RechargeController@index');
    $router->post('/recharge', 'RechargeController@store');

    $router->get('/renewal/{id}', 'RechargeController@renewalIndex');
    $router->post('/renewal', 'RechargeController@renewalStore');
});
