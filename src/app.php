<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;

$app = new Application();
Application::registerBaseServices($app);
Application::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..'),
    'date' => date('Ymd'),
]);

return $app;
