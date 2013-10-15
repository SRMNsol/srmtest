<?php

$app = require __DIR__ . '/../src/app.php';

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

// services for web
$app->register(new App\TemplatingProvider());
$app->register(new SessionServiceProvider());
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => $app['log_dir'] . '/app_' . date('Ymd') . '.log',
));
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

// controllers
$app->mount('/', new App\ControllerProvider());

$app->run();
