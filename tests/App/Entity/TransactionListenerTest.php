<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;

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
        $this->em->persist($transaction);
        $this->em->flush();

        $cashback = $transaction->getCashback();
        $this->assertNotNull($cashback);

        // updating will use the same cashback
        $transaction->setOrderNumber('T234');
        $this->assertEquals($cashback, $transaction->getCashback());
    }
}
