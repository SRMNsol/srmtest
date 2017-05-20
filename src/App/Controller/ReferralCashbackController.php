<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Form\RateType;
use App\Entity\Rate;

class ReferralCashbackController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
			
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
		
        $em = $app['orm.em'];

        $rateRepository = $em->getRepository('App\Entity\Rate');
        $currentRate = $rateRepository->getCurrentRate();

        $rateForm = $app['form.factory']->create(new RateType(), $currentRate->createCopy());

        $rateForm->handleRequest($request);

        if ($rateForm->isValid()) {
            try {
                $rate = $rateForm->getData();

                if ($currentRate->hasSameValues($rate)) {
                    $app['session']->getFlashBag()->add('success', 'No change in rate');

                } else {
                    $em->persist($rate);
                    $em->flush();

                    $app['session']->getFlashBag()->add('success', 'Rate updated');
                }

                return $app->redirect($app['url_generator']->generate('referral_cashback'));

            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        return $app['twig']->render('referral_cashback.html.twig', [
            'rateForm' => $rateForm->createView(),
        ]);
    }
}
