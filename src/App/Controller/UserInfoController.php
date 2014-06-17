<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use App\Form\UserSearchType;

class UserInfoController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Request $request, Application $app)
    {
        $searchForm = $app['form.factory']->create(new UserSearchType());
        $em = $app['orm.em'];
        $userRepository = $em->getRepository('App\Entity\User');

        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            // search user
            $data = $searchForm->getData();
            $user = $userRepository->findOneByEmail($data['email']);
        } else {

        }

        return new Response($app['twig']->render('user_info.html.twig', [
            'searchForm' => $searchForm->createView(),
            'user' => isset($user) ? $user : null,
        ]));
    }
}
