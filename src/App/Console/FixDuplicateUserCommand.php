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

        // fix duplicate emails
        $qb = $em->createQueryBuilder();
        $qb->select(['u.email', 'COUNT(u)']);
        $qb->from('App\Entity\User', 'u');
        $qb->groupBy('u.email');
        $qb->having($qb->expr()->gt('COUNT(u)', 1));

        $results = $qb->getQuery()->execute();

        foreach ($results as $result) {

            $users = $em->getRepository('App\Entity\User')->findBy(['email' => $result['email']], ['id' => 'ASC']);
            $originalUser = array_shift($users);

            $output->writeln(sprintf('Email: %s (%d)', $originalUser->getEmail(), $result[1]));

            foreach ($users as $user) {

                // move all referred users to original user
                foreach ($user->getReferredUsers() as $referredUser) {
                    $referredUser->setReferredBy($originalUser);
                }

                // process payables
                foreach ($user->getPayables() as $payable) {
                    if ($payable instanceof Referral) {
                        // Monthly referrals are summed to original user's
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
                            $payable->setUser($originalUser);
                            $output->writeln(sprintf('+ %s $%.2f', $payable->getConcept(), $payable->getAmount()));
                        }

                    } else {
                        // Cashback and others are assigned to original user
                        $payable->setUser($originalUser);
                        $output->writeln(sprintf('+ %s $%.2f', $payable->getConcept(), $payable->getAmount()));
                    }

                    $em->remove($user);
                }
            }
        }

        $em->flush();

        // fix duplicate alias
        $qb = $em->createQueryBuilder();
        $qb->select(['u.alias', 'COUNT(u)']);
        $qb->from('App\Entity\User', 'u');
        $qb->groupBy('u.alias');
        $qb->having($qb->expr()->gt('COUNT(u)', 1));

        $results = $qb->getQuery()->execute();

        foreach ($results as $result) {

            $users = $em->getRepository('App\Entity\User')->findBy(['alias' => $result['alias']], ['id' => 'ASC']);
            $originalUser = array_shift($users);

            $output->writeln(sprintf('Alias: %s %s (%d)', $originalUser->getEmail(), $result['alias'], $result[1]));

            foreach ($users as $user) {
                $user->setAlias(sprintf('U%d', $user->getId()));
                $output->writeln(sprintf('+ %s %s', $user->getEmail(), $user->getAlias()));
            }
        }

        $em->flush();
    }
}
