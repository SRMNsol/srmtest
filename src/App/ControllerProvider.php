<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $app['charity.controller'] = $app->share(function () use ($app) {
            return new Controller\CharityController($app['orm.em']);
        });

        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        $controllers->get('/merchant/list', 'merchant.controller:listMerchants')
            ->bind('merchant_list');

        $controllers->match('/merchant/edit/{merchantId}', 'merchant.controller:editMerchant')
            ->bind('merchant_edit');

        $controllers->get('/user/info', 'user_info.controller:display')
            ->bind('user_info');

        $controllers->match('/user/edit/{userId}', 'user_info.controller:edit')
            ->bind('user_edit');

        $controllers->match('/referral-cashback', 'referral_cashback.controller:display')
            ->bind('referral_cashback');

        $controllers->get('/charity/list', 'charity.controller:listCharities')
            ->bind('charity_list');

        $charityConverter = function ($charityId) use ($app) {
            $charity = isset($charityId)
                ? $app['orm.em']->find('App\Entity\Charity', $charityId)
                : new Entity\Charity();

            if (null === $charity) {
                throw new NotFoundHttpException('Charity not found');
            }

            return $charity;
        };

        $controllers->match('/charity/edit/{charity}', 'charity.controller:editCharity')
            ->bind('charity_edit')
            ->value('charity', null)
            ->assert('charity', '\d*')
            ->convert('charity', $charityConverter);

        $controllers->post('/charity/delete/{charity}', 'charity.controller:deleteCharity')
            ->bind('charity_delete')
            ->assert('charity', '\d+')
            ->convert('charity', $charityConverter);

        return $controllers;
    }
}
