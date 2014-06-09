<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;

class UserInfoController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function display(Application $app)
    {
        return new Response($app['twig']->render('user_info.html.twig', [

        ]));
    }
}
