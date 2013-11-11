<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require __DIR__ . '/../src/app.php';

// initialize db to register enum type
$db = $app['db'];

return ConsoleRunner::createHelperSet($app['orm.em']);
