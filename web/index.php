<?php



require __DIR__ . '/../vendor/autoload.php';

use App\Application;
$app = new Application();
Application::registerBaseServices($app);
Application::registerWebServices($app);
Application::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..'),
    'date' => date('Ymd'),
]);

// firewalls
$app->register(new App\SecurityProvider());

// controllers
$app->mount('/', new App\ControllerProvider());

$app->run();
