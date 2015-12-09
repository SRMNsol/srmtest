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

        $app['statistics.controller'] = $app->share(function () use ($app) {
            return new Controller\StatisticsController($app['orm.em']);
        });

        $app['transaction.controller'] = $app->share(function () use ($app) {
            return new Controller\TransactionController($app['orm.em']);
        });

        $app['payment_request.controller'] = $app->share(function () use ($app) {
            return new Controller\PaymentRequestController($app['orm.em']);
        });

        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        $controllers->get('/merchant/list', 'merchant.controller:listMerchants')
            ->bind('merchant_list');

        $controllers->match('/merchant/edit/{merchantId}', 'merchant.controller:editMerchant')
            ->bind('merchant_edit');

        $controllers->match('/merchant/create', 'merchant.controller:editMerchant')
            ->bind('merchant_create');

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

        $controllers->get('/statistics', 'statistics.controller:display')
            ->bind('statistics');

        $transactionConverter = function ($transactionId) use ($app) {
            $transaction = isset($transactionId)
                ? $app['orm.em']->find('App\Entity\Transaction', $transactionId)
                : new Entity\Transaction();

            if (null === $transaction) {
                throw new NotFoundHttpException('Transaction not found');
            }

            return $transaction;
        };

        $userConverter = function ($userId) use ($app) {
            $user = isset($userId)
                ? $app['orm.em']->find('App\Entity\User', $userId)
                : new Entity\User();

            if (null === $user) {
                throw new NotFoundHttpException('User not found');
            }

            return $user;
        };

        $controllers->match('/transaction/edit/{user}/{transaction}', 'transaction.controller:editTransaction')
            ->bind('transaction_edit')
            ->value('transaction', null)
            ->assert('user', '\d+')
            ->assert('transaction', '\d*')
            ->convert('user', $userConverter)
            ->convert('transaction', $transactionConverter);

        $controllers->match('/transaction/delete/{user}/{transaction}', 'transaction.controller:deleteTransaction')
            ->bind('transaction_delete')
            ->assert('user', '\d+')
            ->assert('transaction', '\d+')
            ->convert('user', $userConverter)
            ->convert('transaction', $transactionConverter);

        $controllers->match('/payment-request', 'payment_request.controller:display')
            ->bind('payment_request');

        return $controllers;
    }
}
