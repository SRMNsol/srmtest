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

    public function testPaymentUpdateTransactionStatus()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $transaction->setCommission(10.00);
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertEquals(Transaction::STATUS_REGISTERED, $transaction->getStatus());

        $payment = new Payment();
        $payment->setPaymentAt(new \DateTime());
        $payment->setPaymentNumber('P123');
        $payment->setTotal(5.00);
        $transaction->addPayment($payment);
        $this->em->persist($payment);
        $this->em->flush();

        $this->assertEquals(Transaction::STATUS_AVAILABLE, $transaction->getStatus());

        $payment = new Payment();
        $payment->setPaymentAt(new \DateTime());
        $payment->setPaymentNumber('P234');
        $payment->setTotal(3.00);
        $payment->setAdjustment(2.00);
        $transaction->addPayment($payment);
        $this->em->persist($payment);
        $this->em->flush();

        $this->assertEquals(Transaction::STATUS_PROCESSED, $transaction->getStatus());
    }
}
