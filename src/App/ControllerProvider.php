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
		
		$app['reporting.controller'] = $app->share(function () use ($app) {
            return new Controller\ReportingController($app['orm.em']);
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


        $controllers->get('/userinfo/autopost', 'user_info.controller:autopost')
            ->bind('userinfo_autopost');




        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        $controllers->get('/merchant/list', 'merchant.controller:listMerchants')
            ->bind('merchant_list');

			
		$controllers->post('/userinfo/refcheck', 'user_info.controller:refcheck')
            ->bind('userinfo_refcheck');
            
        $controllers->post('/userinfo/popupcheck', 'user_info.controller:popupcheck')
            ->bind('userinfo_popupcheck');
      



        $controllers->post('/userinfo/userstatus', 'user_info.controller:userstatus')
            ->bind('userinfo_userstatus');


    $controllers->post('/userinfo/ajaxdesc', 'user_info.controller:ajaxdesc')
            ->bind('userinfo_ajaxdesc');

        $controllers->post('/userinfo/cmsmanage', 'user_info.controller:cmsmanage')
            ->bind('cms_management');


        $controllers->get('/userinfo/cms', 'user_info.controller:cms')
            ->bind('userinfo_cms');

        $controllers->get('/userinfo/faq', 'user_info.controller:faq')
            ->bind('userinfo_faq');


        $controllers->get('/userinfo/addfaq', 'user_info.controller:addfaq')
            ->bind('userinfo_addfaq');
      
       $controllers->post('/userinfo/faqadd', 'user_info.controller:faqadd')
            ->bind('userinfo_faqadd');
      

       $controllers->get('/userinfo/addform', 'user_info.controller:addform')
            ->bind('userinfo_addform');

     
        $controllers->match('/userinfo/faqedit/{faq}', 'user_info.controller:faqedit')
            ->bind('userinfo_faqedit')
            ->convert('faq', $merchantConverter);



        $controllers->match('/userinfo/faqupdelete/{faq}', 'user_info.controller:faqupdelete')
            ->bind('userinfo_faqdelete')
            ->convert('faq', $merchantConverter);


   $controllers->post('/userinfo/pageadd', 'user_info.controller:pageadd')
            ->bind('userinfo_pageadd');

   $controllers->post('/userinfo/updatepage', 'user_info.controller:updatepage')
            ->bind('userinfo_updatepage');

   $controllers->get('/userinfo/refralbonus', 'user_info.controller:refralbonus')
            ->bind('userinfo_refralbonus');


   $controllers->match('/userinfo/bonusstatus', 'user_info.controller:bonusstatus')
            ->bind('userinfo_bonusstatus');


   $controllers->match('/userinfo/bonusthems', 'user_info.controller:bonusthems')
            ->bind('userinfo_bonusthems');




      $controllers->match('/userinfo/backoffice', 'user_info.controller:backoffice')
            ->bind('userinfo_backoffice');
			
			
        $controllers->post('/merchant/searchexp', 'merchant.controller:searchexp')
            ->bind('merchant_searchexp');


            
      $controllers->match('/userinfo/faqupdate', 'user_info.controller:faqupdate')
            ->bind('userinfo_faqupdate');
          


        $controllers->get('/merchant/date', 'merchant.controller:dateMerchants')
            ->bind('merchant_date');


        $merchantConverter = function ($merchantId) use ($app) {
            $merchant =  $app['orm.em']->find('App\Entity\Merchant', $merchantId);

            if (null === $merchant) {
                throw new NotFoundHttpException('Merchant not found');
            }

            return $merchant;
        };

        $controllers->match('/merchant/create', 'merchant.controller:createMerchant')
            ->bind('merchant_create');
			
			
			
			

        $controllers->match('/merchant/edit/{merchant}', 'merchant.controller:editMerchant')
            ->bind('merchant_edit')
            ->convert('merchant', $merchantConverter);

        $controllers->match('/merchant/expiry/{merchant}', 'merchant.controller:editMerchant')
            ->bind('merchant_expiry')
            ->convert('merchant', $merchantConverter);

 

        $controllers->post('/merchant/update/{merchant}', 'merchant.controller:updateMerchant')
            ->bind('merchant_update')
            ->convert('merchant', $merchantConverter);


        $controllers->match('/merchant/delete/{merchant}', 'merchant.controller:deleteMerchant')
            ->bind('merchant_delete')
            ->convert('merchant', $merchantConverter);

        $controllers->get('/user/info', 'user_info.controller:display')
            ->bind('user_info');
			
		$controllers->get('/user/report', 'user_info.controller:report')
            ->bind('user_report');
			
	$controllers->post('/reporting/cashsearch', 'reporting.controller:cashsearch')
            ->bind('reporting_cashsearch');
			
		$controllers->get('/user/getallreferal', 'user_info.controller:getallreferal')
            ->bind('user_ref');

        $controllers->match('/user/edit/{userId}', 'user_info.controller:edit')
            ->bind('user_edit');
			
		$controllers->get('/reports/shoppingbydate', 'reporting.controller:shoppingbydate')
            ->bind('shoppingbydate');
		
		$controllers->get('/reports/shoppingbystore', 'reporting.controller:shoppingbystore')
            ->bind('shoppingbystore');
			
		$controllers->get('/reports/cashbackreport', 'reporting.controller:cashbackreport')
            ->bind('cashbackreport');

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

        $controllers->match('/statistics/activeuser', 'statistics.controller:activeuser')
            ->bind('statistics_activeuser');
			
			$controllers->post('/statistics/newuser', 'statistics.controller:newuser')
            ->bind('statistics_newuser');
			
			
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
