<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class TransactionListener
{
    /** @ORM\PrePersist @ORM\PreUpdate */
    public function createRelatedEntity(Transaction $transaction, $event)
    {
        $em = $event->getEntityManager();
        $this->assignRate($transaction, $em->getRepository('App\Entity\Rate'));
        $this->assignCashback($transaction, $em->getRepository('App\Entity\Cashback'), $em->getRepository('App\Entity\User'));
    }

    /**
     * We need an additional flush to push Cashback changes that
     * did not make it to the flush for the Transaction
     *
     * @ORM\PostUpdate
     */
    public function flushCashback($transaction, $event)
    {
        $em = $event->getEntityManager();
        $em->flush();
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
            $cashback = new Cashback();
            $cashback->setTransaction($transaction);
        }

        $cashback->calculateAmounts();

        if (null === $cashback->getUser()) {
            $subid = Subid::createFromString($transaction->getTag());
            if (null !== $subid->getUserId()) {
                $user = $userRepository->findOneById($subid->getUserId());
                if (null !== $user) {
                    $cashback->setUser($user);
                }
            }
        }

        $cashback->updateUserLastCashbackDate();

        if (null === $cashback->getConcept()) {
            $merchant = $transaction->getMerchant();
            if (isset($merchant)) {
                $cashback->setConcept($merchant->getName());
            } elseif ($transaction->getCustomMerchant() !== null) {
                $cashback->setConcept($transaction->getCustomMerchant());
            } else {
                $cashback->setConcept('Cashback');
            }
        }
    }
}
