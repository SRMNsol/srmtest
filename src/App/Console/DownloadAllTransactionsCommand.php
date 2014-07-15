<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class DownloadAllTransactionsCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:transactions');
        $this->setDescription('Download transactions from all networks');
        $this->addArgument('start-date', InputArgument::OPTIONAL, 'Start date');
        $this->addArgument('end-date', InputArgument::OPTIONAL, 'End date');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $output->writeln('Popshops network and stores');

        $ret = $this->getApplication()->find('api:networks')->run(new ArrayInput([
            'command' => 'api:networks',
            '--catalog-key' => $app['popshops.catalog_keys']['all_stores']
        ]), $output);

        $output->writeln('Linkshare');

        $ret = $this->getApplication()->find('linkshare:transactions')->run(new ArrayInput([
            'command' => 'linkshare:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
        ]), $output);

        $output->writeln('CJ');

        $ret = $this->getApplication()->find('cj:transactions')->run(new ArrayInput([
            'command' => 'cj:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
        ]), $output);

        $output->writeln('Pepperjam');

        $ret = $this->getApplication()->find('pepperjam:transactions')->run(new ArrayInput([
            'command' => 'pepperjam:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
        ]), $output);

        $ret = $this->getApplication()->find('pepperjam:transactions')->run(new ArrayInput([
            'command' => 'pepperjam:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
            '--update' => true,
        ]), $output);

        $output->writeln('Shareasale');

        $ret = $this->getApplication()->find('shareasale:transactions')->run(new ArrayInput([
            'command' => 'shareasale:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
        ]), $output);

        $ret = $this->getApplication()->find('shareasale:transactions')->run(new ArrayInput([
            'command' => 'shareasale:transactions',
            'start-date' => $input->getArgument('start-date'),
            'end-date' => $input->getArgument('end-date'),
            '--update' => true,
        ]), $output);
    }
}
