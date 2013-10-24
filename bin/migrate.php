<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$params = new StdClass();
$params->action = null;
$params->args = [];

$console = new Application('User data migration', 'n/a');
$console->setAutoExit(false);
$console
    ->register('user:download')
    ->setDefinition([
        new InputOption('gt-id', null, InputOption::VALUE_REQUIRED, 'Id greater than number'),
        new InputOption('limit', null, InputOption::VALUE_REQUIRED, 'limit'),
    ])
    ->setDescription('Download and save user data from Extrabux')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($params) {
        $params->action = 'user_download';
        $params->args[] = $input->getOption('limit') ?: 1;
        $params->args[] = $input->getOption('gt-id');
    })
;

$console->run();

// pass to legacy app
if (isset($params->action)) {
    $path = '/migrate/' . $params->action;
    foreach ($params->args as $arg) {
        $path .= '/' . urlencode($arg);
    }

    $_SERVER = ['APP_PATH' => $path, 'FIXTURES_PATH' => realpath(__DIR__ . '/../data/fixtures')];
    require __DIR__ . '/../beesavy/public/index.php';
}
