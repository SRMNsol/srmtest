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
            ->setDescription('List merchants');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $popshops = $app['popshops.client'];
        $catalogKey = $app['popshops.default_catalog_key'];

        $merchants = $popshops->getMerchants($catalogKey);
        if (count($merchants) > 0) {
            $table = $this->getHelperSet()->get('table');
            $table->setHeaders(array('Id', 'Merchant'));

            foreach ($merchants as $merchant) {
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
