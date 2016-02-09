<?php

namespace App\Tests;

use Silex\WebTestCase as SilexWebTestCase;
use Silex\Provider\ServiceControllerServiceProvider;
use App\Application;
use App\TemplatingProvider;
use App\SecurityProvider;

class WebTestCase extends SilexWebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['session.test'] = true;

        Application::registerBaseServices($app);
        $app->register(new TemplatingProvider());
        $app->register(new ServiceControllerServiceProvider());

        Application::loadConfig($app, __DIR__ . '/../config', [
            'root_dir' => realpath(__DIR__ . '/..'),
        ]);

        // firewalls
        $app->register(new SecurityProvider());


        return $app;
    }
}
