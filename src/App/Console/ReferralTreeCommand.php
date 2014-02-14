<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Referral;
use App\Entity\Payable;

class ReferralTreeCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('beesavy:referral:tree')
            ->setDescription('Print referral tree of user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address of user')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];
        $email = $input->getArgument('email');

        $userRepository = $em->getRepository('App\Entity\User');
        $user = $userRepository->findOneByEmail($email);

        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(['#', 'Level', 'Email', 'Referred By']);

        $level = 7;
        $tree = $user->getReferralTree($level);
        $count = 0;
        foreach ($tree as $level => $children) {
            foreach ($children as $child) {
                $count++;
                $table->addRow([
                    $count,
                    $level,
                    $child->getEmail(),
                    $child->getReferredBy()->getEmail(),
                ]);
            }
        }
        $table->render($output);

        $output->writeln(sprintf('Direct referrals: %d', $user->countDirectReferrals()));
        $output->writeln(sprintf('Indirect referrals 2-%d: %d', $level, $user->countIndirectReferrals($level)));
        $output->writeln(sprintf('Total referral network: %d', $count));
        $output->writeln('DONE');
    }
}
