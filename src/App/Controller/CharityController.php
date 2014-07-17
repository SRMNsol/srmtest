<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;

class CharityController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listCharities(Request $request, Application $app)
    {
        $em = $app['orm.em'];
        $charities = $em->getRepository('App\Entity\Charity')->findBy([], ['name' => 'ASC']);

        return $app['twig']->render('charity_list.html.twig', [
            'charities' => $charities,
        ]);
    }

    public function editCharity(Request $request, Application $application)
    {
        return $app['twig']->render('charity_edit.html.twig', []);
    }
}
