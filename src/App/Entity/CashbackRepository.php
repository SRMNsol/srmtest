<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class CashbackRepository extends EntityRepository
{
    public function getMostRecentUserCashback(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->innerJoin('c.transactions', 't')
            ->where('c.user = :user')
            ->orderBy('t.registeredAt', 'DESC')
            ->groupBy('c')
            ->setParameter('user', $user)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function calculateUserSummary(User $user)
    {
        $qb = $this->createQueryBuilder('c')
            ->select([
                'SUM(c.amount) AS amount',
                'SUM(c.pending) AS pending',
                'SUM(c.available) AS available',
                'SUM(c.processing) AS processing',
                'SUM(c.paid) AS paid'
            ])
            ->where('c.user = :user')
            ->groupBy('c.user')
            ->setParameter('user', $user)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function findCashbackForTransaction(Transaction $transaction)
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.transactions', 't')
            ->where('t.merchant = :merchant')
            ->andWhere('t.network = :network')
            ->andWhere('t.orderNumber = :orderNumber')
            ->groupBy('c')
            ->setParameter('merchant', $transaction->getMerchant())
            ->setParameter('network', $transaction->getNetwork())
            ->setParameter('orderNumber', $transaction->getOrderNumber())
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function findCashbackForUser(User $user, $month = null, $year = null)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $user);

        if ($month !== null && $year !== null) {
            $start = \DateTime::createFromFormat('Y-m-d', "$year-$month-01");
            $end = clone $start;
            $end->add(\DateInterval::createFromDateString('+1 month'));

            $qb->andWhere('c.registeredAt >= :start')
                ->andWhere('c.registeredAt < :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end);
        }

        return $qb->getQuery()->getResult();
    }
}
