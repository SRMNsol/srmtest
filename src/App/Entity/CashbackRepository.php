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
                break;
            default :
                break;
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

    public function getTransactionStats(\DateTime $start, \DateTime $end, array $users = null)
    {
        $before = clone $end;
        $before->add(\DateInterval::createFromDateString('+1 day'));

        $qb = $this->createQueryBuilder('c');
        $qb->join('c.user', 'u', 'WITH', 'c.status <> :invalid');
        $qb->setParameter('invalid', Cashback::STATUS_INVALID);
        $qb->join('c.transactions', 't', 'WITH', 't.status <> :canceled');
        $qb->setParameter('canceled', Transaction::STATUS_CANCELED);

        $qb->addSelect('u');
        $qb->addSelect('SUM(t.total) AS total');
        $qb->where('c.registeredAt >= :after')->setParameter('after', $start);
        $qb->andWhere('c.registeredAt < :before')->setParameter('before', $before);
        $qb->groupBy('c');
        $qb->groupBy('t');
        $qb->having('total > 0');
        if (count($users) > 0) {
            // return users in parameter
            $qb->andWhere('u IN (?3)')->setParameter(3, $users);
        }
        $qb->orderBy('u.id'); // order by id to merge results easily

        $rows = $qb->getQuery()->getResult();

        $result = [];

        // rows is ordered by user id
        $i = 0;
        foreach ($rows as $row) {
            $user = $row[0]->getUser();
            // first pass, or current result not for the same user, increment i
            if ($i === 0 || $result[$i][0] !== $user) {
                $i++;
            }
            // initialize new result
            if (!isset($result[$i])) {
                $result[$i] = [0 => $user, 'total' => 0.00];
            }
            // sum total
            $result[$i]['total'] += $row['total'];
        }

        return $result;
    }

}
