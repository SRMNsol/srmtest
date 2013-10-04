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
            ->addOption('catalog', null, InputOption::VALUE_REQUIRED, 'Specify the catalog name')
            ->addOption('deal-type', null, InputOption::VALUE_REQUIRED, 'Specify the deal type name')
            ->addArgument('keywords', InputArgument::OPTIONAL, 'Specify the product search keywords');
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

        $keywords = $input->getArgument('keywords');
        $dealTypes = $popshops->getDealTypes()->filter(function ($dealType) use ($input) {
            $name = $dealType->getName();
            $type = $input->getOption('deal-type');
            if (isset($type) && preg_match('/' . preg_quote($type) . '/i', $name)) {
                return $dealType;
            }
        });
        $dealType = count($dealTypes) > 0 ? $dealTypes->current() : null;

        $result = $popshops->findDeals($catalogs[$catalog], $dealType, $keywords);
        if (count($result->getDeals()) > 0) {
            $table = $this->getHelperSet()->get('table');

            $table->setHeaders(['Name', 'Type', 'Merchant', 'Ends', 'Code']);
            $table->setRows($result->getDeals()->map(function ($deal) {
                $test = $deal->getDealTypes()->first();
                return [
                    substr($deal->getName(), 0, 80),
                    count($deal->getDealTypes()) > 0 ? $deal->getDealTypes()->current()->getName() : null,
                    $deal->getMerchant() ? $deal->getMerchant()->getName() : null,
                    $deal->getEndOn() ? $deal->getEndOn()->format('m/d/Y') : null,
                    $deal->getCode(),
                ];
            })->toArray());
            $table->render($output);

            $output->writeln('Keywords: ' . $result->getKeywords());
            $output->writeln('Limit/offset: ' . $result->getLimit() . '/' . $result->getOffset());
            $output->writeln('Total results: ' . $result->getDeals()->getTotalCount());

            return;
        }

        $output->writeln('No deals found');
    }
}
