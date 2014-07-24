<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Payment;

class PaymentRequestController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $payments = $this->em->getRepository('App\Entity\Payment')->findAll([], ['status' => Payment::STATUS_PENDING]);

        return $app['twig']->render('payment_request.html.twig', [
            'payments' => $payments,
        ]);
    }
}
