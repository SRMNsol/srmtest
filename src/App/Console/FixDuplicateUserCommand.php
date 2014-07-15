<?php

namespace App\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Referral;

class FixDuplicateUserCommand extends Command
{
    public function configure()
    {
        $this->setName('beesavy:fix:duplicate-user');
        $this->setDescription('Fix db entry where multiple users have the same email');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $em = $app['orm.em'];

        $qb = $em->createQueryBuilder();
        $qb->select(['u.email', 'COUNT(u)']);
        $qb->from('App\Entity\User', 'u');
        $qb->groupBy('u.email');
        $qb->having($qb->expr()->gt('COUNT(u)', 1));

        $results = $qb->getQuery()->execute();

        foreach ($results as $result) {
            $output->writeln(sprintf('%s (%d)', $result['email'], $result[1]));

            $users = $em->getRepository('App\Entity\User')->findBy(['email' => $result['email']], ['id' => 'ASC']);
            $originalUser = array_shift($users);

            foreach ($users as $user) {
                foreach ($user->getPayables() as $payable) {
                    if ($payable instanceof Referral) {
                        // sum it
                        $matchingReferral = $originalUser->getPayables()->filter(function ($p) use ($payable) {
                            return ($p instanceof Referral) && ($p->getMonth() === $payable->getMonth());
                        })->current();

                        if (isset($matchingReferral)) {
                            $matchingReferral->setAmount($matchingReferral->getAmount() + $payable->getAmount());
                            $matchingReferral->setDirect($matchingReferral->getDirect() + $payable->getDirect());
                            $matchingReferral->setIndirect($matchingReferral->getIndirect() + $payable->getIndirect());
                            $matchingReferral->setPending($matchingReferral->getPending() + $payable->getPending());
                            $matchingReferral->setAvailable($matchingReferral->getAvailable() + $payable->getAvailable());

                            $output->writeln(sprintf('+ Referral %s $%.2f', $payable->getMonth(), $payable->getAmount()));
                            $em->remove($payable);
                        } else {
                            $user->removePayable($payable);
                            $originalUser->addPayable($payable);

                            $output->writeln(sprintf('+ %s $%.2f', $payable->getConcept(), $payable->getAmount()));
                            $em->remove($payable);
                        }

                    } else {
                        $user->removePayable($payable);
                        $originalUser->addPayable($payable);

                        $output->writeln(sprintf('+ %s $%.2f', $payable->getConcept(), $payable->getAmount()));
                        $em->remove($payable);
                    }

                    $em->remove($user);
                }
            }
        }

        $em->flush();
    }
}
