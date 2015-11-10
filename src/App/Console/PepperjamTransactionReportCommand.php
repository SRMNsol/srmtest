<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class PepperjamTransactionReportCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('pepperjam:transactions')
            ->setDescription('Download Pepperjam transactions')
            ->addArgument('start-date', InputArgument::OPTIONAL, 'Start date')
            ->addArgument('end-date', InputArgument::OPTIONAL, 'End date')
            ->addOption('update', null, InputOption::VALUE_NONE, 'Download transaction update')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        if ($output->isDebug()) {
            $app['reporting.debug'] = true;
        }

        $report = $app['pepperjam_report'];

        $startDate = new \DateTime($input->getArgument('start-date') ?: 'yesterday');
        $endDate = $input->getArgument('end-date')
            ? new \DateTime($input->getArgument('end-date'))
            : clone $startDate;

        $output->writeln(sprintf('Downloading from %s to %s', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        $transactions = $input->getOption('update')
            ? $report->getTransactionDeltaReport($startDate, $endDate)
            : $report->getTransactionDetailsReport($startDate, $endDate);

        $table = new Table($output);
        $table->setHeaders(['#', 'Date', 'Merchant', 'Order #', 'Total', 'Commission', 'Tag', 'Status']);

        foreach ($transactions as $transaction) {
            $table->addRow([
                $transaction->getId(),
                $transaction->getRegisteredAt()->format('m/d/Y H:i'),
                $transaction->getMerchant()->getName(),
                $transaction->getOrderNumber(),
                sprintf('$%.2f', $transaction->getTotal()),
                sprintf('$%.2f', $transaction->getCommission()),
                $transaction->getTag(),
                $transaction->getStatus(),
            ]);
        }

        $table->render();
        $output->writeln(sprintf('Total %d transactions', count($transactions)));
    }
}
