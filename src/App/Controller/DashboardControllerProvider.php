<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

class DashboardControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {
            return $app->render('dashboard.html.twig');
        });

        return $controllers;
    }
}
