<?php

$app = require __DIR__ . '/../src/app.php';

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Knp\Provider\ConsoleServiceProvider;

$app->register(new ConsoleServiceProvider(), [
    'console.name' => 'Beesavy Console',
    'console.version' => 'n/a',
    'console.project_directory' => realpath(__DIR__ . '/..'),
]);

$console = $app['console'];
$console->setCatchExceptions(true);

$console->setHelperSet(new HelperSet([
    new TableHelper(),
    new DialogHelper(),
    new FormatterHelper(),
]));

$console->addCommands([
    new App\Console\AssetDumpCommand(),
]);

$console->run();
