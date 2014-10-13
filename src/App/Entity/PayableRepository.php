<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class PayableRepository extends EntityRepository
{
    public function calculateUserSummary(User $user)
    {
        $qb = $this->createQueryBuilder('p')
            ->select([
                'SUM(p.amount) AS amount',
                'SUM(p.pending) AS pending',
                'SUM(p.available) AS available',
                'SUM(p.processing) AS processing',
                'SUM(p.paid) AS paid'
            ])
            ->where('p.user = :user')
            ->andWhere('p.status <> :invalid')
            ->groupBy('p.user')
            ->setParameter('user', $user)
            ->setParameter('invalid', Payable::STATUS_INVALID)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function makeAvailable(\DateTime $date = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->update('App\Entity\Payable', 'p')
            ->set('p.status', ':avail')
            ->set('p.available', 'p.available + p.pending')
            ->set('p.pending', 0)
            ->where('p.availableAt <= :date')
            ->andWhere('p.status IN (:status)')
            ->setParameter('date', $date ?: new \DateTime())
            ->setParameter('status', [Payable::STATUS_PENDING, Payable::STATUS_AVAILABLE])
            ->setParameter('avail', Payable::STATUS_AVAILABLE)
        ;

        return $qb->getQuery()->execute();
    }

    public function getTotalOtherPayableForUser(User $user, \DateTime $start = null, \DateTime $end = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('SUM(p.amount)');
        $qb->where('p INSTANCE OF App\Entity\Payable');
        $qb->andWhere('p.user = :user')->setParameter('user', $user);
        $qb->andWhere('p.status <> :invalid')->setParameter('invalid', Payable::STATUS_INVALID);

        if ($start !== null) {
            $qb->andWhere('p.registeredAt >= :after')->setParameter('after', $start);
        }

        if ($end !== null) {
            $until = clone $end;
            $until->add(\DateInterval::createFromDateString('+1 day'));

            $qb->andWhere('p.registeredAt < :before')->setParameter('before', $until);
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}
