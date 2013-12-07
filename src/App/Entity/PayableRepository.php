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
}
