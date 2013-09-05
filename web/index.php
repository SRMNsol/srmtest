<?php

$app = require __DIR__ . '/../src/app.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

// services for web
$app->register(new TwigServiceProvider(), array(
    'twig.path' => $app['template_path']
));
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => $app['log_path'] . '/app.log',
));
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

// controllers
$app->mount('/', new App\MainControllerProvider());

$app->run();
