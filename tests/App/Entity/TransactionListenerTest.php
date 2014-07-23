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
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $transaction->setTotal(50.00);
        $transaction->setCommission(5.00);

        $merchant = new Merchant();
        $merchant->setId(123);
        $merchant->setName('Test');
        $merchant->setNetworkMerchantId('123');
        $merchant->setUrl('http://');
        $this->em->persist($merchant);

        $transaction->setMerchant($merchant);

        $this->em->persist($transaction);
        $this->em->flush();

        $cashback = $transaction->getCashback();
        $this->assertNotNull($cashback);
        $this->assertEquals('pending', $cashback->getStatus());
        $this->assertEquals(2.50, $cashback->getAmount());

        // updating will use the same cashback
        $transaction->setOrderNumber('T234');
        $transaction->setCommission(6.00);
        $this->em->flush();

        $this->assertEquals($cashback, $transaction->getCashback());
        $this->assertEquals('Test', $cashback->getConcept());
        $this->assertEquals($transaction->getRegisteredAt()->format('Y-m-d'), $cashback->getRegisteredAt()->format('Y-m-d'));
        $this->assertEquals(3.00, $cashback->getAmount());

        // zero value is pending until 90 days
        $transaction->setCommission(0.00);
        $this->em->flush();
        $this->assertEquals(0, $cashback->getAmount());
        $this->assertEquals('pending', $cashback->getStatus());

        // after 90 days, cashback status is updated
        $transaction->setRegisteredAt(new \DateTime('90 days ago'));
        $this->em->flush();
        $this->assertEquals('canceled', $cashback->getStatus());
        $transaction->setCommission(123.00);
        $this->em->flush();
        $this->assertEquals('available', $cashback->getStatus());

    }
}
