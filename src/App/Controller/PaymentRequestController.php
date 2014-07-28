<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Payment;
use App\Form\PaymentSelectorType;
use App\Form\Model\PaymentCollection;

class PaymentRequestController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $payments = $this->em->getRepository('App\Entity\Payment')->getPendingPayments();

        $collection = new PaymentCollection();
        $selector = $app['form.factory']->create(new PaymentSelectorType(), $collection, [
            'payments' => $payments,
        ]);

        $selector->handleRequest($request);
        if ($selector->isValid()) {
            try {
                foreach ($collection->getPayments() as $payment) {
                    $payment->markAsPaid();
                }
                $this->em->flush();

                $app['session']->getFlashBag()->add('success', sprintf(
                    '%d payment(s) marked as paid',
                    count($collection->getPayments())
                ));

                return $app->redirect($app['url_generator']->generate('payment_request'));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        }

        return $app['twig']->render('payment_request.html.twig', [
            'payments' => $payments,
            'selector' => $selector->createView(),
        ]);
    }
}
