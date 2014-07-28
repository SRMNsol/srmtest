<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class FixUserCashbackCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:fix:user-cashback');
        $this->setDescription('Move processing amount to available');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];

        $qb = $em->createQueryBuilder();
        $qb->select(['p']);
        $qb->from('App\Entity\Payable', 'p');
        $qb->where('p.processing > 0');

        $results = $qb->getQuery()->getResult();

        $table = new Table($output);
        $table->setHeaders(['#', 'Date', 'Processing', 'User']);
        foreach ($results as $payable) {
            $table->addRow([
                $payable->getId(),
                $payable->getRegisteredAt() ? $payable->getRegisteredAt()->format('Y-m-d') : null,
                sprintf('%.2f', $payable->getProcessing()),
                $payable->getUser() ? $payable->getUser()->getEmail() : null,
            ]);

            $payable->setAvailable($payable->getAvailable() + $payable->getProcessing());
            $payable->setProcessing(0.00);
        }
        $em->flush();
        $table->render();
        $output->writeln(sprintf('Total %d items', count($results)));
    }
}
