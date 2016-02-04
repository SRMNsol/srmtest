<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;

$app = new Application();
Application::registerBaseServices($app);
Application::registerReportingServices($app);
$app->register(new App\TemplatingProvider());

Application::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..'),
    'date' => date('Ymd'),
]);

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
    /* Beesavy */
    new App\Console\ReferralTreeCommand(),
    new App\Console\ReferralCalculationCommand(),

    /* Dev */
    new App\Console\AssetDumpCommand(),
    new App\Console\FixDuplicateUserCommand(),
    new App\Console\MailerTestCommand(),
    new App\Console\RemovePaymentCommand(),
    new App\Console\S3TestCommand(),
    new App\Console\PopshopsMerchantIdCommand(),
    new App\Console\ExportCategoriesCommand(),

    /* Transaction related */
    new App\Console\LinkshareTransactionReportCommand(),
    new App\Console\CommissionJunctionTransactionReportCommand(),
    new App\Console\PepperjamTransactionReportCommand(),
    new App\Console\ShareasaleTransactionReportCommand(),
    new App\Console\ImpactRadiusTransactionReportCommand(),
    new App\Console\DownloadAllTransactionsCommand(),
]);

$console->run();
