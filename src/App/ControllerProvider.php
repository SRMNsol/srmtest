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

        $app['category.controller'] = $app->share(function () use ($app) {
            return new Controller\CategoryController($app['orm.em']->getRepository('App\Entity\Category'), $app['orm.em']);
        });

        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        $controllers->get('/merchant/list', 'merchant.controller:listMerchants')
            ->bind('merchant_list');

        $merchantConverter = function ($merchantId) use ($app) {
            $merchant =  $app['orm.em']->find('App\Entity\Merchant', $merchantId);

            if (null === $merchant) {
                throw new NotFoundHttpException('Merchant not found');
            }

            return $merchant;
        };

        $controllers->match('/merchant/create', 'merchant.controller:editMerchant')
            ->bind('merchant_create');

        $controllers->match('/merchant/edit/{merchant}', 'merchant.controller:editMerchant')
            ->bind('merchant_edit')
            ->convert('merchant', $merchantConverter);

        $controllers->post('/merchant/delete/{merchant}', 'merchant.controller:deleteMerchant')
            ->bind('merchant_delete')
            ->convert('merchant', $merchantConverter);

        $controllers->get('/user/info', 'user_info.controller:display')
            ->bind('user_info');

        $controllers->match('/user/edit/{userId}', 'user_info.controller:edit')
            ->bind('user_edit');

        $controllers->match('/referral-cashback', 'referral_cashback.controller:display')
            ->bind('referral_cashback');

        $controllers->get('/charity/list', 'charity.controller:listCharities')
            ->bind('charity_list');

        $charityConverter = function ($charityId) use ($app) {
            $charity =  $app['orm.em']->find('App\Entity\Charity', $charityId);

            if (null === $charity) {
                throw new NotFoundHttpException('Charity not found');
            }

            return $charity;
        };

        $controllers->match('/charity/create', 'charity.controller:editCharity')
            ->bind('charity_create');

        $controllers->match('/charity/edit/{charity}', 'charity.controller:editCharity')
            ->bind('charity_edit')
            ->convert('charity', $charityConverter);

        $controllers->post('/charity/delete/{charity}', 'charity.controller:deleteCharity')
            ->bind('charity_delete')
            ->convert('charity', $charityConverter);

        $controllers->get('/statistics', 'statistics.controller:display')
            ->bind('statistics');

        $transactionConverter = function ($transactionId) use ($app) {
            $transaction = $app['orm.em']->find('App\Entity\Transaction', $transactionId);

            if (null === $transaction) {
                throw new NotFoundHttpException('Transaction not found');
            }

            return $transaction;
        };

        $userConverter = function ($userId) use ($app) {
            $user = $app['orm.em']->find('App\Entity\User', $userId);

            if (null === $user) {
                throw new NotFoundHttpException('User not found');
            }

            return $user;
        };

        $controllers->match('/transaction/create/{user}', 'transaction.controller:editTransaction')
            ->bind('transaction_create')
            ->convert('user', $userConverter);

        $controllers->match('/transaction/edit/{user}/{transaction}', 'transaction.controller:editTransaction')
            ->bind('transaction_edit')
            ->convert('user', $userConverter)
            ->convert('transaction', $transactionConverter);

        $controllers->post('/transaction/delete/{user}/{transaction}', 'transaction.controller:deleteTransaction')
            ->bind('transaction_delete')
            ->convert('user', $userConverter)
            ->convert('transaction', $transactionConverter);

        $controllers->match('/payment-request', 'payment_request.controller:display')
            ->bind('payment_request');

        $categoryConverter = function ($categoryId) use ($app) {
            $category = $app['orm.em']->find('App\Entity\Category', $categoryId);

            if ($category === null) {
                throw new NotFoundHttpException('Invalid category id');
            }

            return $category;
        };

        $controllers->get('/category/list', 'category.controller:listCategories')
            ->bind('category_list');

        $controllers->match('/category/edit/{category}', 'category.controller:editCategory')
            ->bind('category_edit')
            ->convert('category', $categoryConverter);

        $controllers->match('/category/create', 'category.controller:editCategory')
            ->bind('category_create');

        $controllers->post('/category/delete/{category}', 'category.controller:deleteCategory')
            ->bind('category_delete')
            ->convert('category', $categoryConverter);

        return $controllers;
    }
}
