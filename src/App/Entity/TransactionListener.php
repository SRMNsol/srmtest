<?php

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class TransactionListener
{
    public function prePersist(Transaction $transaction, LifecycleEventArgs $event)
    {
        $this->assignRate($transaction, $event->getEntityManager()->getRepository('App\Entity\Rate'));
    }

    public function preUpdate(Transaction $transaction, PreUpdateEventArgs $event)
    {
        $this->assignRate($transaction, $event->getEntityManager()->getRepository('App\Entity\Rate'));
    }

    public function assignRate(Transaction $transaction, RateRepository $rateRepository)
    {
        $rate = $rateRepository->getRateForTransaction($transaction);
        if (null !== $rate) {
            $transaction->setRate($rate);
        }
    }
}
