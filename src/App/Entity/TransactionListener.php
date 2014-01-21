<?php

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityRepository;

class TransactionListener
{
    public function prePersist(Transaction $transaction, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $this->assignRate($transaction, $em->getRepository('App\Entity\Rate'));
        $this->assignCashback($transaction, $em->getRepository('App\Entity\Cashback'), $em->getRepository('App\Entity\User'));
    }

    public function preUpdate(Transaction $transaction, PreUpdateEventArgs $event)
    {
        $em = $event->getEntityManager();
        $this->assignRate($transaction, $em->getRepository('App\Entity\Rate'));
        $this->assignCashback($transaction, $em->getRepository('App\Entity\Cashback'), $em->getRepository('App\Entity\User'));
    }

    public function assignRate(Transaction $transaction, RateRepository $rateRepository)
    {
        $rate = $rateRepository->findRateForTransaction($transaction);
        if (null !== $rate) {
            $transaction->setRate($rate);
        }
    }

    public function assignCashback(Transaction $transaction, CashbackRepository $cashbackRepository, EntityRepository $userRepository)
    {
        $cashback = $cashbackRepository->findCashbackForTransaction($transaction);

        if (null === $cashback) {
            $cashback = new Cashback();
        }

        if (false === $cashback->getTransactions()->contains($transaction)) {
            $cashback->addTransaction($transaction);
        }

        $subid = Subid::createFromString($transaction->getTag());
        if (null !== $subid->getUserId()) {
            $user = $userRepository->findOneById($subid->getUserId());
            if (null !== $user) {
                $cashback->setUser($user);
            }
        }

        $cashback->calculateAmount();
    }
}
