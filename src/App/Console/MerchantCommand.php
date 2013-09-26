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
            ->addArgument('catalog', InputArgument::OPTIONAL, 'Specify the catalog name from the configured catalog in config/global.yml or config/local.yml if exists (popshops.catalog_keys) ');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $popshops = $app['popshops.client'];
        $catalogs = $app['popshops.catalog_keys'];
        $catalog = $input->getArgument('catalog');

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

        $result = $popshops->getMerchants($catalogs[$catalog]);
        if (count($result->getMerchants()) > 0) {
            $table = $this->getHelperSet()->get('table');
            $table->setHeaders(['Id', 'Merchant']);

            foreach ($result->getMerchants() as $merchant) {
                $table->addRow(array(
                    $merchant->getId(),
                    $merchant->getName(),
                ));
            }

            $table->render($output);
            return;
        }

        $output->writeln('No merchants found');
    }
}
