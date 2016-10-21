<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;

$app = new Application();
Application::registerBaseServices($app);
Application::registerReportingServices($app);
$app->register(new App\TemplatingProvider());

Application::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..'),
    'date' => date('Ymd'),
]);

use Knp\Provider\ConsoleServiceProvider;

$app->register(new ConsoleServiceProvider(), [
    'console.name' => 'Beesavy Console',
    'console.version' => 'n/a',
    'console.project_directory' => realpath(__DIR__ . '/..'),
]);

$console = $app['console'];
$console->setCatchExceptions(true);

$app['dispatcher']->addListener(ConsoleEvents::EXCEPTION, function (ConsoleExceptionEvent $event) use ($app) {
    // log
    $app['monolog']->addCritical(sprintf(
        'Exception thrown while running command "%s" [%s] %s',
        $event->getCommand()->getName(),
        get_class($event->getException()),
        $event->getException()->getMessage()
    ));
});
$console->setDispatcher($app['dispatcher']);

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
    new App\Console\BackupLogsCommand(),

    /* Transaction related */
    new App\Console\LinkshareTransactionReportCommand(),
    new App\Console\CommissionJunctionTransactionReportCommand(),
    new App\Console\PepperjamTransactionReportCommand(),
    new App\Console\ShareasaleTransactionReportCommand(),
    new App\Console\ImpactRadiusTransactionReportCommand(),
    new App\Console\DownloadAllTransactionsCommand(),
]);

$console->run();
