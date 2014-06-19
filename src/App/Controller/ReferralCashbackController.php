<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Form\RateType;

class ReferralCashbackController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $rateForm = $app['form.factory']->create(new RateType());

        return $app['twig']->render('referral_cashback.html.twig', [
            'rateForm' => $rateForm->createView(),
        ]);
    }
}
