<?php

$app = require __DIR__ . '/../config/popshops-cli-config.php';

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
    new App\Console\ExtrabuxImportTransactionCommand(),
    new App\Console\ExtrabuxImportReferralCommand(),
    new App\Console\ExtrabuxImportAdjustmentCommand(),
    new App\Console\ExtrabuxImportUserCommand(),
    new App\Console\ReferralTreeCommand(),
    new App\Console\ReferralCalculationCommand(),
    new Popshops\Console\MerchantCommand(),
    new Popshops\Console\ProductCommand(),
    new Popshops\Console\DealCommand(),
    new Popshops\Console\NetworkCommand(),
    new Popshops\Console\LinkshareTransactionReportCommand(),
    new Popshops\Console\LinksharePaymentReportCommand(),
]);

$console->run();
