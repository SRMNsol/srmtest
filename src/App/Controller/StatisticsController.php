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
            $range = $dateForm->getData();

            $params['totalCashback'] = $app['orm.em']->getRepository('App\Entity\Cashback')->getTotalCashback($range['startDate'], $range['endDate']);
            $params['totalShoppers'] = $app['orm.em']->getRepository('App\Entity\User')->getTotalShoppers($range['startDate'], $range['endDate']);
            $params['totalNewUsers'] = $app['orm.em']->getRepository('App\Entity\User')->getTotalNewUsers($range['startDate'], $range['endDate']);
            $params['totalReferrers'] = $app['orm.em']->getRepository('App\Entity\User')->getTotalReferrers($range['startDate'], $range['endDate']);
            $params['topUsers'] = $app['orm.em']->getRepository('App\Entity\User')->getTopCommission($range['startDate'], $range['endDate']);
        }

        return $app['twig']->render('statistics.html.twig', [
            'dateForm' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
    }
}
