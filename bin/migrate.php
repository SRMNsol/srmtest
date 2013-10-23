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

    ])
    ->setDescription('Download and save user data from Extrabux')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($params) {
        $params->action = 'user_download';
    })
;

$console->run();

// pass to legacy app
if (isset($params->action)) {
    $path = '/migrate/' . $params->action;
    foreach ($params->args as $arg) {
        $path .= '/' . urlencode($arg);
    }

    $_SERVER = ['APP_PATH' => $path];
    require __DIR__ . '/../beesavy/public/index.php';
}
