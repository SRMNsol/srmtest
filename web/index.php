<?php

$app = require __DIR__ . '/../src/app.php';

// services for web
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['template_path']
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $app['log_path'] . '/app.log',
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

// controllers
$app->mount('/', new App\Controller\DashboardControllerProvider());

$app->run();
