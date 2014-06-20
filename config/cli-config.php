<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\DialogHelper;
use Doctrine\DBAL\Migrations\Tools\Console\Command as Migrations;

$app = require __DIR__ . '/../src/app.php';

// initialize db to register enum type
$db = $app['db'];

$helperSet = ConsoleRunner::createHelperSet($app['orm.em']);

// add dialog
$helperSet->set(new DialogHelper(), 'dialog');

// add migrations commands
$commands[] = new Migrations\DiffCommand();
$commands[] = new Migrations\ExecuteCommand();
$commands[] = new Migrations\GenerateCommand();
$commands[] = new Migrations\MigrateCommand();
$commands[] = new Migrations\StatusCommand();
$commands[] = new Migrations\VersionCommand();

return $helperSet;
