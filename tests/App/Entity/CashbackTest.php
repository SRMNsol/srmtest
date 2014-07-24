<?php

use App\Entity\Cashback;
use App\Entity\Transaction;
use App\Entity\Rate;
use App\Tests\OrmTestCase;

class CashbackTest extends OrmTestCase
{
    /**
     * @expectedException Exception
     */
    public function testValidateAmountsOnSave()
    {
        $cashback = new Cashback();
        $cashback->setPending(100);
        $cashback->setAvailable(100);
        $cashback->setProcessing(100);
        $cashback->setPaid(100);
        $cashback->setAmount(333); // wrong sum
        $this->em->persist($cashback);
        $this->em->flush();
    }

    public function testUpdateStatusCallback()
    {
        $cashback = new Cashback();
        $cashback->setAmount(100);
        $cashback->setPending(100);
        $this->em->persist($cashback);
        $this->em->flush();
        $this->assertEquals(Cashback::STATUS_PENDING, $cashback->getStatus());

        $cashback->setPending(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Cashback::STATUS_AVAILABLE, $cashback->getStatus());

        $cashback->setAvailable(0)->setProcessing(100);
        $this->em->flush();
        $this->assertEquals(Cashback::STATUS_PROCESSING, $cashback->getStatus());

        $cashback->setProcessing(0)->setPaid(100);
        $this->em->flush();
        $this->assertEquals(Cashback::STATUS_PAID, $cashback->getStatus());

        $cashback->setStatus(Cashback::STATUS_INVALID);
        $cashback->setPaid(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Cashback::STATUS_INVALID, $cashback->getStatus());
    }

    public function testAvailableDateCallback()
    {
        $cashback = new Cashback();
        $cashback->setRegisteredAt(new \DateTime());
        $this->em->persist($cashback);
        $this->em->flush();
        $availDate = new \DateTime('+90 days');

        $this->assertEquals(
            $availDate->format('Y-m-d'),
            $cashback->getAvailableAt()->format('Y-m-d')
        );
    }

    public function testZeroAmountIsPendingUntil90Days()
    {
        $cashback = new Cashback();
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new \DateTime());
        $transaction->setOrderNumber('ABC123');
        $transaction->setTotal(0.00);
        $transaction->setCommission(0.00);
        $cashback->setTransaction($transaction);
        $this->em->persist($transaction);
        $this->em->persist($cashback);
        $this->em->flush();

        $this->assertEquals(0, $cashback->getAmount());
        $this->assertEquals(0, $cashback->getPending());
        $this->assertEquals(Cashback::STATUS_PENDING, $cashback->getStatus());
    }

    public function testCashbackIsAvailableAfter90Days()
    {
        $cashback = new Cashback();
        $transaction = new Transaction();
        $transaction->setOrderNumber('ABC123');
        $transaction->setRegisteredAt(new \DateTime('90 days ago'));
        $transaction->setTotal(100.00);
        $transaction->setCommission(10.00);
        $rate = $this->em->getRepository('App\Entity\Rate')->createDefaultRate();
        $transaction->setRate($rate);
        $cashback->setTransaction($transaction);
        $this->em->persist($transaction);
        $this->em->persist($cashback);
        $this->em->persist($rate);
        $this->em->flush();

        $this->assertGreaterThan(0, $cashback->getAmount());
        $this->assertGreaterThan(0, $cashback->getAvailable());
        $this->assertEquals(Cashback::STATUS_AVAILABLE, $cashback->getStatus());
    }

    public function testCashbackIsInvalidForNonSale()
    {
        $cashback = new Cashback();
        $transaction = new Transaction();
        $transaction->setOrderNumber('ABC123');
        $transaction->setRegisteredAt(new \DateTime('90 days ago'));

        // total = 0, commission > 0
        $transaction->setTotal(0.00);
        $transaction->setCommission(10.00);

        $rate = $this->em->getRepository('App\Entity\Rate')->createDefaultRate();
        $transaction->setRate($rate);
        $cashback->setTransaction($transaction);
        $this->em->persist($transaction);
        $this->em->persist($cashback);
        $this->em->persist($rate);
        $this->em->flush();

        $this->assertEquals(0, $cashback->getAmount());
        $this->assertEquals(0, $cashback->getPending());
        $this->assertEquals(0, $cashback->getAvailable());
        $this->assertEquals(Cashback::STATUS_INVALID, $cashback->getStatus());
    }

    public function testNoUpdateWhenProcessingOrPaid()
    {
        $cashback = new Cashback();
        $transaction = new Transaction();
        $transaction->setOrderNumber('ABC123');
        $transaction->setRegisteredAt(new \DateTime('90 days ago'));
        $transaction->setTotal(100.00);
        $transaction->setCommission(10.00);
        $rate = $this->em->getRepository('App\Entity\Rate')->createDefaultRate();
        $rate->setLevel0(0.10);
        $transaction->setRate($rate);
        $cashback->setTransaction($transaction);
        $this->em->persist($transaction);
        $this->em->persist($cashback);
        $this->em->persist($rate);
        $this->em->flush();

        $this->assertEquals(1, (int) $cashback->getAmount());
        $this->assertEquals(1, (int) $cashback->getAvailable());
        $this->assertEquals(Cashback::STATUS_AVAILABLE, $cashback->getStatus());

        // update transaction
        $transaction->setCommission(20.00);
        $this->em->flush();
        $this->assertEquals(2, (int) $cashback->getAmount());

        // mark as processing
        $cashback->setProcessing($cashback->getAvailable());
        $cashback->setAvailable(0.00);
        $cashback->setStatus(Cashback::STATUS_PROCESSING);
        $transaction->setCommission(30.00);
        $this->em->flush();
        $this->assertEquals(2, (int) $cashback->getAmount());
        $this->assertEquals(Cashback::STATUS_PROCESSING, $cashback->getStatus());

        // mark as paid
        $cashback->setPaid($cashback->getProcessing());
        $cashback->setProcessing(0.00);
        $cashback->setStatus(Cashback::STATUS_PAID);
        $transaction->setCommission(40.00);
        $this->em->flush();
        $this->assertEquals(2, (int) $cashback->getAmount());
        $this->assertEquals(Cashback::STATUS_PAID, $cashback->getStatus());
    }
}
