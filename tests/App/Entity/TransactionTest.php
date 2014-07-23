<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Payment;

class TransactionTest extends OrmTestCase
{
    /**
     * Transaction needs minimum registerAt and orderNumber.
     */
    public function testMinimumRequirements()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertGreaterThan(0, $transaction->getId());
    }
}
