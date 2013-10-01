<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DealCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('popshops:deals')
            ->setDescription('Find deals')
            ->addArgument('catalog', InputArgument::OPTIONAL, 'Specify the catalog name')
            ->addArgument('keywords', InputArgument::OPTIONAL, 'Specify the product search keywords');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelperSet()->get('container')->getContainer();
        $popshops = $app['popshops.client'];
        $catalogs = $app['popshops.catalog_keys'];
        $catalog = 'all_stores';

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

        $keywords = $input->getArgument('keywords');
        $dealTypes = $popshops->getDealTypes()->filter(function ($dealType) use ($input) {
            if ($dealType->getId() === $input->getArgument('deal-type')) {
                return $dealType;
            }
        });
        $dealType = count($dealTypes) > 0 ? $dealTypes->first() : null;

        $result = $popshops->findDeals($catalogs[$catalog], $dealType, $keywords);
        if (count($result->getDeals()) > 0) {
            $table = $this->getHelperSet()->get('table');

            $table->setHeaders(['Name', 'Type', 'Merchant']);
            $table->setRows($result->getDeals()->map(function ($deal) {
                return [
                    substr($deal->getName(), 0, 100),
                    $deal->getDealType() ? $deal->getDealType()->getName() : null,
                    $deal->getMerchant() ? $deal->getMerchant()->getName() : null,
                ];

            })->toArray());
            $table->render($output);

            $output->writeln('Keywords: ' . $result->getKeywords());
            $output->writeln('Limit/offset: ' . $result->getLimit() . '/' . $result->getOffset());
            $output->writeln('Total results: ' . $result->getItemCount());

            return;
        }

        $output->writeln('No deals found');
    }
}
