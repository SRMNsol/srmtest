<?php

$app = require __DIR__ . '/../src/app.php';

use Symfony\Component\Console\Application as ConsoleApp;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;

use App\Console\ContainerHelper;

$console = new ConsoleApp('PopShops Console', '1.0');
$console->setCatchExceptions(true);

$console->setHelperSet(new HelperSet([
    new ContainerHelper($app),
    new TableHelper(),
    new DialogHelper(),
    new FormatterHelper(),
]));

$console->addCommands([
    new App\Console\AssetDumpCommand(),
    new App\Console\MerchantCommand(),
    new App\Console\ProductCommand(),
]);

$console->run();
