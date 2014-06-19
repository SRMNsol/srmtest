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
            ->addOption('exclude', null, InputOption::VALUE_REQUIRED, 'Exclude these email address (comma separated)')
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

        // make cashback available
        $em->getRepository('App\Entity\Cashback')->makeCashbackAvailable(new \DateTime());

        // pull users
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

        $exclude = $input->getOption('exclude');
        if (null !== $exclude) {
            $excludeEmails = explode(',', $exclude);
            $excludeEmails = array_map('trim', $excludeEmails);

            $queryBuilder
                ->andWhere("u.email NOT IN (:excludes)")
                ->setParameter('excludes', $excludeEmails)
            ;
        }

        $results = $queryBuilder->getQuery()->iterate();

        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(['User', 'Month', 'Amount', 'Available', 'Pending', 'Direct', 'Indirect', 'Status']);

        foreach ($results as $row) {
            $user = $row[0];
            $user = $em->merge($user);
            $output->writeln(sprintf('User: %s (%s)', $user->getEmail(), $yearMonth));

            $referralRepository = $em->getRepository('App\Entity\Referral');
            $referral = $referralRepository->createUserReferral($user, $month, $year);

            $table->setRows([[
                sprintf('%-20.20s', $user->getEmail()),
                $referral->getMonth(),
                sprintf('$%.2f', $referral->getAmount()),
                sprintf('$%.2f', $referral->getAvailable()),
                sprintf('$%.2f', $referral->getPending()),
                sprintf('$%.2f', $referral->getDirect()),
                sprintf('$%.2f', $referral->getIndirect()),
                $referral->getStatus(),
            ]]);

            $table->render($output);

            $em->clear();
        }

        $output->writeln('DONE');
    }
}
