<?php

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TransactionListener
{
    public function prePersist(Transaction $transaction, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $this->assignRate($transaction, $em->getRepository('App\Entity\Rate'));
        $this->assignCashback($transaction, $em->getRepository('App\Entity\Cashback'));
    }

    public function preUpdate(Transaction $transaction, PreUpdateEventArgs $event)
    {
        $em = $event->getEntityManager();
        $this->assignRate($transaction, $em->getRepository('App\Entity\Rate'));
        $this->assignCashback($transaction, $em->getRepository('App\Entity\Cashback'));
    }

    public function assignRate(Transaction $transaction, RateRepository $rateRepository)
    {
        $rate = $rateRepository->findRateForTransaction($transaction);
        if (null !== $rate) {
            $transaction->setRate($rate);
        }
    }

    public function assignCashback(Transaction $transaction, CashbackRepository $cashbackRepository)
    {
        $cashback = $cashbackRepository->findCashbackForTransaction($transaction);

        if (null === $cashback) {
            $cashback = new Cashback();
        }

        if (false === $cashback->getTransactions()->contains($transaction)) {
            $cashback->addTransaction($transaction);
        }
    }
}
