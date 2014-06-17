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
            ->andWhere('c.status <> :invalid')
            ->orderBy('t.registeredAt', 'DESC')
            ->groupBy('c')
            ->setParameter('user', $user)
            ->setParameter('invalid', Cashback::STATUS_INVALID)
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
            ->andWhere('c.status <> :invalid')
            ->groupBy('c.user')
            ->setParameter('user', $user)
            ->setParameter('invalid', Cashback::STATUS_INVALID)
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
        $start = null;
        $end = null;

        if ($month !== null && $year !== null) {
            $start = new \DateTime("$year-$month-01");
            $end = clone $start;
            $end->add(\DateInterval::createFromDateString('+1 month'));
        }

        return $this->findCashbackForUserByDateRange($user, $start, $end);
    }

    public function findCashbackForUserByDateRange(User $user, \DateTime $from = null, \DateTime $to = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.user = :user');
        $qb->setParameter('user', $user);
        $qb->andWhere('c.status <> :invalid');
        $qb->setParameter('invalid', Cashback::STATUS_INVALID);

        if (isset($from)) {
            $from->setTime(0, 0);
            $qb->andWhere('c.registeredAt >= :start');
            $qb->setParameter('start', $start);
        }

        if (isset($to)) {
            $to->setTime(0, 0);
            $qb->andWhere('c.registeredAt < :end');
            $qb->setParameter('end', $start);
        }

        return $qb->getQuery()->getResult();
    }

    public function makeCashbackAvailable($date = null)
    {
        if (null === $date) {
            $date = new \DateTime();
        }

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->update('App\Entity\Cashback', 'c')
            ->set('c.status', ':avail')
            ->where('c.availableAt <= :date')
            ->andWhere('c.status = :status')
            ->setParameter('date', $date)
            ->setParameter('status', Cashback::STATUS_PENDING)
            ->setParameter('avail', Cashback::STATUS_AVAILABLE)
        ;

        return $qb->getQuery()->execute();
    }
}
