<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function login(Request $request, Application $app)
    {
    	///echo 'ddddddddddd'; exit();

        return new Response($app['twig']->render('login.html.twig', [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]));
    }
}
