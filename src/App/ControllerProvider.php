<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApp $app)
    {
        $controllers = $app['controllers_factory'];

        $app['main.controller'] = $app->share(function () use ($app) {
            return new Controller\MainController($app['orm.em']);
        });

        $app['auth.controller'] = $app->share(function () use ($app) {
            return new Controller\AuthController();
        });

        $app['merchant.controller'] = $app->share(function () use ($app) {
            return new Controller\MerchantController($app['orm.em']);
        });

        $app['user_info.controller'] = $app->share(function () use ($app) {
            return new Controller\UserInfoController($app['orm.em']);
        });

        $app['referral_cashback.controller'] = $app->share(function () use ($app) {
            return new Controller\ReferralCashbackController($app['orm.em']);
        });

        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        $controllers->get('/merchant/list', 'merchant.controller:listMerchants')
            ->bind('merchant_list');

        $controllers->match('/merchant/edit/{merchantId}', 'merchant.controller:editMerchant')
            ->bind('merchant_edit');

        $controllers->get('/user-info', 'user_info.controller:display')
            ->bind('user_info');

        $controllers->get('/referral-cashback', 'referral_cashback.controller:display')
            ->bind('referral_cashback');

        return $controllers;
    }
}
