<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class CashbackRepository extends EntityRepository
{
    public function getMostRecentUserCashback(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->innerJoin('c.transaction', 't')
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

    public function findCashbackForUserByDateRange(User $user, \DateTime $start = null, \DateTime $end = null, $order = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.user = :user');
        $qb->setParameter('user', $user);
        $qb->andWhere('c.status <> :invalid');
        $qb->setParameter('invalid', Cashback::STATUS_INVALID);

        if (isset($start)) {
            $start->setTime(0, 0);
            $qb->andWhere('c.registeredAt >= :start');
            $qb->setParameter('start', $start);
        }

        if (isset($end)) {
            $end->add(\DateInterval::createFromDateString('+1 day'))->setTime(0, 0);
            $qb->andWhere('c.registeredAt < :end');
            $qb->setParameter('end', $end);
        }

        switch ($order) {
            case 'latest' :
                $qb->orderBy('c.registeredAt', 'DESC');
                $qb->addOrderBy('c.id', 'DESC');
                break;
            default :
                break;
        }

        return $qb->getQuery()->getResult();
    }

    public function getTotalCashback(\DateTime $start, \DateTime $end)
    {
        $until = clone $end;
        $until->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('c');
        $qb->select('SUM(c.amount)');
        $qb->where('c.status <> :invalid')->setParameter('invalid', Cashback::STATUS_INVALID);
        $qb->andWhere('c.registeredAt >= :after')->setParameter('after', $start);
        $qb->andWhere('c.registeredAt < :before')->setParameter('before', $until);

        return $qb->getQuery()->getSingleScalarResult();
    }
}
