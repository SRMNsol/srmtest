<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApp $app)
    {
        $controllers = $app['controllers_factory'];

        $app['main.controller'] = $app->share(function () use ($app) {
            $controller = new Controller\MainController();
            $controller->setTwig($app['twig']);

            return $controller;
        });

        $app['auth.controller'] = $app->share(function () use ($app) {
            $controller = new Controller\AuthController();
            $controller->setTwig($app['twig']);

            return $controller;
        });

        $controllers->get('/', 'main.controller:dashboard')
            ->bind('homepage');

        $controllers->get('/login', 'auth.controller:login')
            ->bind('login');

        return $controllers;
    }
}
