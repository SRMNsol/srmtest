<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application as CustomApp;
use Igorw\Silex\ConfigServiceProvider;

$app = new CustomApp();

$app->register(new ConfigServiceProvider(__DIR__ . "/../config/prod.yml", array(
    'root_path' => realpath(__DIR__ . '/..'),
)));

if (getenv('APP_ENV') === 'dev') {
    $app->register(new ConfigServiceProvider(__DIR__ . '/../config/dev.yml'));
}

// services
$app->register(new App\CacheProvider());
$app->register(new App\PopshopsProvider());

return $app;
