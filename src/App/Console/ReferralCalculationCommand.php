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
            ->addArgument('month', InputArgument::REQUIRED, 'Year month format YYYYmm')
            ->addArgument('email', InputArgument::OPTIONAL, 'Process user by email')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];
        $email = $input->getArgument('email');
        $yearMonth = $input->getArgument('month');
        $year = substr($yearMonth, 0, 4);
        $month = substr($yearMonth, 4, 2);

        $userRepository = $em->getRepository('App\Entity\User');
        $user = $userRepository->findOneByEmail($email);

        $referralRepository = $em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->calculateUserReferral($user, $month, $year);
        $table = $this->getHelperSet()->get('table');

        $output->writeln(sprintf('Concept: %s (%s)', $referral->getConcept(), $yearMonth));
        $output->writeln(sprintf('Amount: $%.2f', $referral->getAmount()));
        $output->writeln(sprintf('Available: $%.2f', $referral->getAvailable()));
        $output->writeln(sprintf('Pending: $%.2f', $referral->getPending()));
        $output->writeln(sprintf('Indirect: $%.2f', $referral->getIndirect()));
        $output->writeln(sprintf('Direct: $%.2f', $referral->getDirect()));

        $output->writeln('DONE');
    }
}
