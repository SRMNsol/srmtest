<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ReferralRepository extends EntityRepository
{
    public function getMostRecentUserReferral(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->orderBy('r.availableAt', 'DESC')
            ->setParameter('user', $user)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function calculateUserSummary(User $user)
    {
        $qb = $this->createQueryBuilder('r')
            ->select([
                'SUM(r.amount) AS amount',
                'SUM(r.pending) AS pending',
                'SUM(r.available) AS available',
                'SUM(r.processing) AS processing',
                'SUM(r.paid) AS paid'
            ])
            ->where('r.user = :user')
            ->groupBy('r.user')
            ->setParameter('user', $user)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function calculateUserReferral(User $user, $level, $month, $year)
    {

    }
}
