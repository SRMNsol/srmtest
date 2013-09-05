<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class MainControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApp $app)
    {
        $controllers = $app['controllers_factory'];

        $app['main.controller'] = $app->share(function () use ($app) {
            return (new MainController($app['request']))
                ->setTwig($app['twig']);
        });

        $controllers->get('/', 'main.controller:dashboard');

        return $controllers;
    }
}
