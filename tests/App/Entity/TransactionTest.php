<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;

class TransactionTest extends OrmTestCase
{
    /**
     * Transaction requirements: registerAt, orderNumber
     */
    public function testPersistingTransaction()
    {
        $this->createSchema(['App\Entity\Transaction', 'App\Entity\Rate']);

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertGreaterThan(0, $transaction->getId());
    }
}
