<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MerchantCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('popshops:merchants')
            ->setDescription('List merchants')
            ->addOption('catalog', null, InputOption::VALUE_REQUIRED, 'Specify the catalog name from the configured catalog in config/global.yml or config/local.yml if exists (popshops.catalog_keys) ')
            ->addOption('prefix', null, InputOption::VALUE_REQUIRED, 'Specify the merchants name prefix')
            ->addOption('filters', null, InputOption::VALUE_NONE, 'If set, will print all available filters' );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $popshops = $app['popshops.client'];
        $catalogs = $app['popshops.catalog_keys'];
        $catalog = $input->getOption('catalog');

        if (!isset($catalogs[$catalog])) {
            $dialog = $this->getHelperSet()->get('dialog');
            $catalog = $dialog->askAndValidate(
                $output,
                'Please specify the catalog (' . implode(', ', array_keys($catalogs)) . '): ',
                function ($answer) use ($catalogs) {
                    if (!isset($catalogs[$answer])) {
                        throw new \RunTimeException('Invalid catalog name');
                    }

                    return $answer;
                },
                3
            );
        }

        $result = $popshops->findMerchants($catalogs[$catalog]);
        $merchants = $result->getMerchants()->filterByNamePrefix($input->getOption('prefix'));

        if (count($result) > 0) {
            $table = $this->getHelperSet()->get('table');
            $table->setHeaders(['Id', 'Merchant', 'Deals']);

            foreach ($merchants as $merchant) {
                $table->addRow(array(
                    $merchant->getId(),
                    $merchant->getName(),
                    $merchant->getDealCount(),
                ));
            }

            $table->render($output);

            if ($input->getOption('filters')) {
                $table->setHeaders(['Merchant Type', 'Count']);
                $table->setRows($result->getMerchantTypes()->map(function ($merchantType) {
                    return [$merchantType->getName(), $merchantType->getProductCount()];
                })->toArray());
                $table->render($output);
            }

            $output->writeln('Catalog key: ' . $merchants->getCatalogKey());
            $output->writeln('Total merchants: ' . $merchants->getTotalCount());
            $output->writeln('Total deals: ' . array_sum($merchants->map(function ($merchant) {
                return $merchant->getDealCount();
            })->toArray()));

            return;
        }

        $output->writeln('No merchants found');
    }
}
