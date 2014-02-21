<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Referral;
use App\Entity\Payable;

class ReferralCalculationCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('beesavy:referral:calculate')
            ->setDescription('Calculate referral commission')
            ->addOption('month', null, InputOption::VALUE_REQUIRED, 'Year month format YYYYmm')
            ->addArgument('email', InputArgument::OPTIONAL, 'Process user by email')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];
        $email = $input->getArgument('email');
        $yearMonth = $input->getOption('month') ?: date('Ym');
        if (preg_match('/[0-9]{6}/', $yearMonth)) {
            $year = substr($yearMonth, 0, 4);
            $month = substr($yearMonth, 4, 2);
        } else {
            throw new \RuntimeException("Invalid year-month format");
        }

        $queryBuilder = $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
        ;

        if (null !== $email) {
            $queryBuilder
                ->where('u.email = :email')
                ->setParameter('email', $email)
            ;
        }

        $results = $queryBuilder->getQuery()->iterate();

        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(['User', 'Amount', 'Available', 'Pending', 'Direct', 'Indirect']);

        foreach ($results as $row) {
            $user = $row[0];
            $user = $em->merge($user);
            $output->writeln(sprintf('User: %s (%s)', $user->getEmail(), $yearMonth));

            $referralRepository = $em->getRepository('App\Entity\Referral');
            $referral = $referralRepository->calculateUserReferral($user, $month, $year);

            $table->setRows([[
                sprintf('%-20.20s', $user->getEmail()),
                sprintf('$%.2f', $referral->getAmount()),
                sprintf('$%.2f', $referral->getAvailable()),
                sprintf('$%.2f', $referral->getPending()),
                sprintf('$%.2f', $referral->getDirect()),
                sprintf('$%.2f', $referral->getIndirect()),
            ]]);

            $table->render($output);

            $em->clear();
        }

        $output->writeln('DONE');
    }
}
