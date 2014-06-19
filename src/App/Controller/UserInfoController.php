<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Form\UserSearchType;

class UserInfoController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $searchForm = $app['form.factory']->create(new UserSearchType());
        $em = $app['orm.em'];
        $totalCashback = 0.00;
        $totalSpending = 0.00;
        $totalPayment = 0.00;
        $totalReferral = 0.00;
        $cashbackList = [];
        $user = null;

        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            try {
                $data = $searchForm->getData();
                $user = $em->getRepository('App\Entity\User')->findOneByEmail($data['email']);
                if ($user === null) {
                    throw new \RuntimeException('User not found');
                }

                $cashbackList = $em->getRepository('App\Entity\Cashback')->findCashbackForUserByDateRange($user, $data['startDate'], $data['endDate'], 'latest');
                foreach ($cashbackList as $cashback) {
                    $totalCashback += $cashback->getAmount();
                    $totalSpending += $cashback->calculateTransactionTotal();
                    $totalPayment += $cashback->getPaid();
                }

                $referral = $em->getRepository('App\Entity\Referral')->calculateUserReferral($user, $data['startDate'], $data['endDate']);
                $totalReferral = $referral['commission'];

            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } else {
        }

        return new Response($app['twig']->render('user_info.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => $user,
            'cashbackList' => $cashbackList,
            'totalSpending' => $totalSpending,
            'totalCashback' => $totalCashback,
            'totalReferral' => $totalReferral,
            'totalPayment' => $totalPayment,
            'totalEarning' => $totalCashback + $totalReferral,
        ]));
    }
}
