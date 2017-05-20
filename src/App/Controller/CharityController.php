<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Entity\Charity;
use App\Form\CharityType;

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

        $deleteForm = $app['form.factory']->create();

        return $app['twig']->render('charity_list.html.twig', [
            'charities' => $charities,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    public function editCharity(Charity $charity = null, Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new CharityType(), $charity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $charity = $form->getData();
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

    public function deleteCharity(Charity $charity, Request $request, Application $app)
    {
		 $url = $request->getUri();
        $tokens = explode('/', $url);
       $cha_id=$tokens[sizeof($tokens)-1]; 
	           $em = $app['orm.em'];
        $connection = $em->getConnection();
	  	$RAW_QUERY = 'DELETE  FROM Charity  WHERE id= '.$cha_id.''; 
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
		
		
        try {
            $app['orm.em']->remove($charity);
            $app['orm.em']->flush();
            $app['session']->getFlashBag()->add('success', sprintf('Charity %s deleted', $charity->getName()));
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', 'Delete failed');
        }

        return $app->redirect($app['url_generator']->generate('charity_list'));
    }
}
