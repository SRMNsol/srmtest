<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use App\Entity\Cashback;

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
}
