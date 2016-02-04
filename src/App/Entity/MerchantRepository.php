<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class MerchantRepository extends EntityRepository
{
    public function getTopStores()
    {
        return $this->findBy(['topStore' => true]);
    }

    public function getActiveMerchants()
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.active = :active');
        $qb->setParameter('active', true);
        $qb->orderBy('m.name');

        return $qb->getQuery()->getResult();
    }

    public function getActiveMerchant($id)
    {
        return $this->findOneBy(['id' => $id, 'active' => true]);
    }
}
