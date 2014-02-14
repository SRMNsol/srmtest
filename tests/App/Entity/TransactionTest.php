<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;

class TransactionTest extends OrmTestCase
{
    /**
     * Transaction needs minimum registerAt and orderNumber.
     * Transaction is assigned rate by entity listener
     */
    public function testPersistingTransaction()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertGreaterThan(0, $transaction->getId());
        $this->assertNotNull($transaction->getRate());
    }
}
