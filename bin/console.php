<?php

$app = require __DIR__ . '/../src/app.php';

use Symfony\Component\Console\Application as ConsoleApp;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;

use App\Console\ContainerHelper;

$console = new ConsoleApp('PopShops Console', '1.0');
$console->setCatchExceptions(true);

$console->setHelperSet(new HelperSet(array(
    new ContainerHelper($app),
    new TableHelper(),
)));

$console->addCommands(array(
    new App\Console\MerchantCommand(),
    new App\Console\AssetDumpCommand(),
));

$console->run();
