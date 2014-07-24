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
            ->groupBy('p.user')
            ->setParameter('user', $user)
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
            ->setParameter('status', [Cashback::STATUS_PENDING, Cashback::STATUS_AVAILABLE])
            ->setParameter('avail', Cashback::STATUS_AVAILABLE)
        ;

        return $qb->getQuery()->execute();
    }
}
