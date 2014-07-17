<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Entity\Charity;

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

    public function editCharity(Charity $charity, Request $request, Application $app)
    {
        $form = $app['form.factory']->createBuilder('form', $charity)
            ->add('name')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $app['orm.em']->persist($charity);
                $app['orm.em']->flush();

                $app['session']->getFlashBag()->add('success', 'Charity updated');

                return $app->redirect($app['url_generator']->generate('charity_list'));

            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        }

        return $app['twig']->render('charity_edit.html.twig', ['form' => $form->createView()]);
    }
}
