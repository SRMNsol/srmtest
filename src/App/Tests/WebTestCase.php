<?php

namespace App\Tests;

use Silex\WebTestCase as SilexWebTestCase;
use Silex\Provider\TwigServiceProvider;

class WebTestCase extends SilexWebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['session.test'] = true;

        $app->register(new TwigServiceProvider(), array(
            'twig.path' => $app['template_path']
        ));

        return $app;
    }
}
