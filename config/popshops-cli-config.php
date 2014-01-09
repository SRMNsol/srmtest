<?php

use Popshops\Silex\PopshopsExtraServiceProvider;

$app = require __DIR__ . '/../src/app.php';

$app->register(new PopshopsExtraServiceProvider());

return $app;
