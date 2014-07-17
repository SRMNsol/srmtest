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
        }

        return $app['twig']->render('statistics.html.twig', [
            'dateForm' => $dateForm->createView(),
            'display' => $display,
        ] + $params);
    }
}
