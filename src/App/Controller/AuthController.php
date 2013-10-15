<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController implements TwigInterface
{
    use TwigTrait;

    public function login(Request $request, Application $app)
    {
        return new Response($this->render('login.html.twig', [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]));
    }
}
