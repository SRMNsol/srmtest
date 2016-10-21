<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class CommissionJunctionTransactionReportCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('cj:transactions')
            ->setDescription('Download Commission Junction transactions')
            ->addArgument('start-date', InputArgument::OPTIONAL, 'Start date')
            ->addArgument('end-date', InputArgument::OPTIONAL, 'End date')
            ->addOption('update-all', null, InputOption::VALUE_NONE, 'Query transaction history on new and modified transactions')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        if ($output->isDebug()) {
            $app['reporting.debug'] = true;
        }

        $report = $app['cj_report'];

        $startDate = new \DateTime($input->getArgument('start-date') ?: 'yesterday');
        $endDate = $input->getArgument('end-date')
            ? new \DateTime($input->getArgument('end-date'))
            : clone $startDate;
        $updateAll = $input->getOption('update-all');

        // normalize time
        $startDate->setTime(0, 0);
        $endDate->setTime(0, 0);

        $output->writeln(sprintf('Downloading from %s to %s', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        $app['reporting.logger']->addInfo(sprintf('COMMISSION JUNCTION %s %s', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        $transactions = $report->getCommissionDetailReport($startDate, $endDate, $updateAll);

        $table = new Table($output);
        $table->setHeaders(['#', 'Date', 'Merchant', 'Order #', 'Total', 'Commission', 'Tag', 'Status']);

        $salesTotal = 0;
        $commissionTotal = 0;

        foreach ($transactions as $transaction) {
            $salesTotal += $transaction->getTotal();
            $commissionTotal += $transaction->getCommission();

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
        $output->writeln(sprintf('Total %d transactions, sales $%.2f, commission $%.2f', count($transactions), $salesTotal, $commissionTotal));
    }
}
