<?php

$app = require __DIR__ . '/../src/app.php';

// services for web
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['template_path']
));

// controllers
$app->mount('/', new App\Controller\DashboardControllerProvider());

$app->run();
