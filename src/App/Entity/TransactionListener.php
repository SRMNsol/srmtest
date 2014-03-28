<?php

namespace App\Entity;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\EntityRepository;

class TransactionListener
{
    public function preFlush(Transaction $transaction, PreFlushEventArgs $event)
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
        $cashback = $transaction->getCashback();

        if (null === $cashback) {
            $cashback = $cashbackRepository->findCashbackForTransaction($transaction);
        }

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

        if (null === $cashback->getConcept()) {
            $merchant = $transaction->getMerchant();
            if (isset($merchant)) {
                $cashback->setConcept($merchant->getName());
            }
        }

        if (null === $cashback->getRegisteredAt()) {
            $cashback->setRegisteredAt($transaction->getRegisteredAt());
        }
    }
}
