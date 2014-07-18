<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Form\DateRangeType;

class StatisticsController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $dateForm = $app['form.factory']->create(new DateRangeType());

        $params = [];
        $display = false;

        $dateForm->handleRequest($request);
        if ($dateForm->isValid()) {
            $display = true;
            $query = $dateForm->getData() + [
                'sort' => $request->get('sort', 'commission'),
                'dir' => $request->get('dir', 'down'),
            ];

            $userRepo = $app['orm.em']->getRepository('App\Entity\User');
            $cashbackRepo = $app['orm.em']->getRepository('App\Entity\Cashback');

            $params['total_cashback'] = $cashbackRepo->getTotalCashback($query['start_date'], $query['end_date']);
            $params['total_shoppers'] = $userRepo->getTotalShoppers($query['start_date'], $query['end_date']);
            $params['total_new_users'] = $userRepo->getTotalNewUsers($query['start_date'], $query['end_date']);
            $params['total_referrers'] = $userRepo->getTotalReferrers($query['start_date'], $query['end_date']);
            $params['top_users'] = $userRepo->getTopUsers($query['start_date'], $query['end_date']);


            $params['start_date'] = $query['start_date'];
            $params['end_date'] = $query['end_date'];
            $params['sort'] = $query['sort'];
            $params['dir'] = $query['dir'];
        }

        return $app['twig']->render('statistics.html.twig', [
            'date_form' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
    }
}
