<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Payment;
use App\Entity\Rate;

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

    /**
     * Test calculation of commission by level.
     */
    public function testCalculateCommission()
    {
        $transaction = new Transaction();
        $transaction->setCommission(100);

        $rate = new Rate();
        $rate->setLevel0(0.5);
        $rate->setLevel1(0.05);
        $transaction->setRate($rate);

        $this->assertEquals(50, $transaction->getCommissionByLevel(0), 0.01);
        $this->assertEquals(5, $transaction->getCommissionByLevel(1), 0.01);
    }

    /**
     * Test rounding when commission is small
     * Issue #78
     */
    public function testRoundingCommission()
    {
        $rate = new Rate();
        $rate->setLevel0(0.5);
        $rate->setLevel1(0.05);

        $transaction = new Transaction();
        $transaction->setRate($rate);

        $transaction->setCommission(0.10);
        $this->assertEquals(0.05, $transaction->getCommissionByLevel(0), 0.01);
        $this->assertEquals(0, $transaction->getCommissionByLevel(1), 0.01);

        $transaction->setCommission(7.75);
        $this->assertEquals(3.87, $transaction->getCommissionByLevel(0), 0.01);
        $this->assertEquals(0.38, $transaction->getCommissionByLevel(1), 0.01);
    }
}
