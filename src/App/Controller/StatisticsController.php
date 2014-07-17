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

            $params['total_cashback'] = $app['orm.em']->getRepository('App\Entity\Cashback')->getTotalCashback($range['startDate'], $range['endDate']);
        }

        return $app['twig']->render('statistics.html.twig', [
            'dateForm' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
    }
}
