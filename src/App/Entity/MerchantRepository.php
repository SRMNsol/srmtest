<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class MerchantRepository extends EntityRepository
{
    public function getTopStores()
    {
        return $this->findBy(['topStore' => true]);
    }
}
