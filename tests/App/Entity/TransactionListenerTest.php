<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Merchant;

class TransactionListenerTest extends OrmTestCase
{
    public function testRateCreation()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $rate = $transaction->getRate();
        $this->assertNotNull($rate);
    }

    public function testCashbackCreation()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime('2014-02-12'));
        $transaction->setOrderNumber('T123');

        $merchant = new Merchant();
        $merchant->setId(123);
        $merchant->setName('Test');
        $merchant->setNetworkMerchantId('123');
        $merchant->setUrl('http://');
        $transaction->setMerchant($merchant);

        $this->em->persist($transaction);
        $this->em->persist($merchant);
        $this->em->flush();

        $cashback = $transaction->getCashback();
        $this->assertNotNull($cashback);

        // updating will use the same cashback
        $transaction->setOrderNumber('T234');
        $this->assertEquals($cashback, $transaction->getCashback());
        $this->assertEquals('Test', $cashback->getConcept());
        $this->assertEquals('2014-02-12', $cashback->getRegisteredAt()->format('Y-m-d'));
    }
}
