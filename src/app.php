<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application as CustomApp;
use Igorw\Silex\ConfigServiceProvider;

$app = new CustomApp();

$app->register(new ConfigServiceProvider(__DIR__ . "/../config/global.yml", ['root_dir' => realpath(__DIR__ . '/..')]));

try {
    $app->register(new ConfigServiceProvider(__DIR__ . '/../config/dev.yml'));
} catch (InvalidArgumentException $e) {
    // no local config
}

    // services
$app->register(new App\CacheProvider());
$app->register(new App\PopshopsProvider());

return $app;
