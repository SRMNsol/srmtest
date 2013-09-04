<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;
use Igorw\Silex\ConfigServiceProvider;

$app = new Application();

$app->register(new ConfigServiceProvider(__DIR__ . "/../config/prod.yml", array(
    'root_path' => realpath(__DIR__ . '/..'),
)));

if (getenv('APP_ENV') === 'dev') {
    $app->register(new ConfigServiceProvider(__DIR__ . '/../config/dev.yml'));
}

// services

return $app;
