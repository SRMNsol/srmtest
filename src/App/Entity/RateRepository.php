<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use App\Entity\Transaction;
use App\Entity\Rate;

class RateRepository extends EntityRepository
{
    public function createDefaultRate()
    {
        $rate = new Rate();
        $rate->setLevel0(0.5);
        $rate->setLevel1(0.1);
        $rate->setLevel2(0.05);
        $rate->setLevel3(0.05);
        $rate->setLevel4(0.05);
        $rate->setLevel5(0.05);
        $rate->setLevel6(0.05);
        $rate->setLevel7(0.05);

        $em = $this->getEntityManager();
        $em->persist($rate);
        $em->flush();

        return $rate;
    }

    public function getCurrentRate()
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1);

        try {
            $rate = $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $rate = $this->createDefaultRate();
        }

        return $rate;
    }

    public function findRateForTransaction(Transaction $transaction)
    {
        // get last rate created before transaction
        $queryBuilder = $this->createQueryBuilder('r')
            ->andWhere('r.createdAt <= :date')
            ->orderBy('r.id', 'DESC')
            ->setParameter('date', $transaction->getRegisteredAt())
            ->setMaxResults(1);

        try {
            $rate = $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // no result, try if there is current rate
            $rate = $this->getCurrentRate();
        }

        return $rate;
    }
}
