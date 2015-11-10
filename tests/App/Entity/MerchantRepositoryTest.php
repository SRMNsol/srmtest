<?php

use App\Tests\OrmTestCase;
use App\Entity\Merchant;

class MerchantRepositoryTest extends OrmTestCase
{
    public function testGetTopStores()
    {
        $merchant1 = new Merchant();
        $merchant1->setNetworkMerchantId('111');
        $merchant1->setName('Merchant 1');

        $merchant2 = new Merchant();
        $merchant2->setTopStore(true);
        $merchant2->setNetworkMerchantId('222');
        $merchant2->setName('Merchant 2');

        $this->em->persist($merchant1);
        $this->em->persist($merchant2);
        $this->em->flush();
        $this->em->clear();

        $topStores = $this->em->getRepository('App\Entity\Merchant')->getTopStores();
        $this->assertEquals(1, count($topStores));
        $this->assertEquals(2, $topStores[0]->getId());
    }
}
