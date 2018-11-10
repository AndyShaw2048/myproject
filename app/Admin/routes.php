<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/',function(){
        return redirect('/admin/amazonThr');
    });
    $router->resource('/mcinfo', MCInfoController::class);
    $router->resource('/scripts', ScriptController::class);
    //序列号生成
    $router->get('/serials/generate', 'MCController@index');
    $router->post('/serials/generate', 'MCController@store');
    //序列号导出
    $router->get('/serials/export', 'MCController@export');
    //充值
    $router->get('/recharge', 'RechargeController@index');
    $router->post('/recharge', 'RechargeController@store');
    //续费
    $router->get('/amazon/renewal/{id}', 'RechargeController@renewalIndex');
    $router->post('/amazon/renewal', 'RechargeController@renewalStore');

    /**
     * Facebook模块
     */
    $router->resource('/facebook', FacebookController::class);
    $router->post('/facebook', 'FacebookController@store');
    $router->post('/facebook/edit', 'FacebookController@editStore');
    //--续费
    $router->get('/facebook/renewal/{id}', 'FacebookController@renewalIndex');
    $router->post('/facebook/renewal', 'FacebookController@renewalStore');

    /**
     * Messenger模块
     */
    $router->resource('/messenger', MessengerController::class);
    $router->post('/messenger', 'MessengerController@store');
    $router->post('/messenger/edit', 'MessengerController@editStore');
    //--续费
    $router->get('/messenger/renewal/{id}', 'MessengerController@renewalIndex');
    $router->post('/messenger/renewal', 'MessengerController@renewalStore');

    /**
     * Wish模块
     */
    $router->resource('/wish', WishController::class);
    $router->post('/wish', 'WishController@store');
    $router->post('/wish/edit', 'WishController@editStore');
    //--续费
    $router->get('/wish/renewal/{id}', 'WishController@renewalIndex');
    $router->post('/wish/renewal', 'WishController@renewalStore');
    $router->post('/wish/renewal', 'WishController@renewalStore');
    /**
     * Whatsapp模块
     */
    $router->resource('/whatsapp', WhatsappController::class);
    $router->post('/whatsapp', 'WhatsappController@store');
    $router->post('/whatsapp/edit', 'WhatsappController@editStore');
    //查看机器码下的号码
    $router->get('/whatsapp/telephones/{id?}', 'WhatsappController@getTelephones')->where('id','[0-9]+');
    $router->post('/whatsapp/telephones/export','WhatsappController@exportTelephones');
    //清楚机器码下的号码
    $router->post('/whatsapp/telephones/clear','WhatsappController@clearTelephones');
    //--续费
    $router->get('/whatsapp/renewal/{id}', 'WhatsappController@renewalIndex');
    $router->post('/whatsapp/renewal', 'WhatsappController@renewalStore');

    /**
     * Line模块
     */
    $router->resource('/line', LineController::class);
    $router->post('/line', 'LineController@store');
    $router->post('/line/edit', 'LineController@editStore');
    //查看机器码下的号码
    $router->get('/line/telephones/{id?}', 'LineController@getTelephones')->where('id','[0-9]+');
    $router->post('/line/telephones/export','LineController@exportTelephones');
    //清楚机器码下的号码
    $router->post('/line/telephones/clear','LineController@clearTelephones');
    //--续费
    $router->get('/line/renewal/{id}', 'LineController@renewalIndex');
    $router->post('/line/renewal', 'LineController@renewalStore');

    /**
     * Amazon_2模块
     */
    $router->resource('/amazon2', AmazonController::class);
    $router->post('/amazon2', 'AmazonController@store');
    $router->post('/amazon2/edit', 'AmazonController@editStore');
    //--续费
    $router->get('/amazon2/renewal/{id}', 'AmazonController@renewalIndex');
    $router->post('/amazon2/renewal', 'AmazonController@renewalStore');

    /**
     * Amazon_2模块
     */
    $router->resource('/amazonThr', AmazonThrController::class);
    $router->post('/amazonThr', 'AmazonThrController@store');
    $router->post('/amazonThr/edit', 'AmazonThrController@editStore');
    //--续费
    $router->get('/amazonThr/renewal/{id}', 'AmazonThrController@renewalIndex');
    $router->post('/amazonThr/renewal', 'AmazonThrController@renewalStore');

    /**
     * Instagram模块
     */
    $router->resource('/instagram', InstagramController::class);
    $router->post('/instagram', 'InstagramController@store');
    $router->post('/instagram/edit', 'InstagramController@editStore');
    //--续费
    $router->get('/instagram/renewal/{id}', 'InstagramController@renewalIndex');
    $router->post('/instagram/renewal', 'Instagramontroller@renewalStore');
    $router->post('/instagram/renewal', 'InstagramController@renewalStore');

    /**
     * DLA模块
     */
    $router->resource('/dla', DLAController::class);
    $router->post('/dla/{id}', 'DLAController@purchase');

    /**
     * 邀请码模块
     */
    $router->resource('/invitation', InvitationController::class);
    $router->post('/invitation', 'InvitationController@generate');

    /**
     * 佣金返利模块
     */
    $router->resource('/rebate', RebateController::class);
//    $router->post('/rebate', 'InvitationController@generate');
    $router->post('/rebate/withdraw','RebateController@withdraw');

    /**
     * 佣金提现模块
     */
    $router->resource('/withdraw', WithdrawController::class);
    $router->get('/withdraw/export/un','WithdrawController@export');
});
