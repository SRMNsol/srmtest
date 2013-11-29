<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use App\Entity\Transaction;

class RateRepository extends EntityRepository
{
    public function getCurrentRate()
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function getRateForTransaction(Transaction $transaction)
    {
        $rates = $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();

        $current = null;
        foreach ($rates as $rate) {
            $current = $rate;
            if ($transaction->getRegisteredAt() > $rate->getCreatedAt()) {
                break;
            }
        }

        return $current;
    }
}
