<?php

require __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Igorw\Silex\ConfigServiceProvider;

$app = new Application();

$env = getenv('APP_ENV') ?: 'prod';
$app->register(new ConfigServiceProvider(__DIR__ . "/../config/$env.yml"));

return $app;
