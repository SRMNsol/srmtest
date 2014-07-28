<?php

use App\Tests\OrmTestCase;
use App\Entity\Payable;
use App\Entity\Cashback;
use App\Entity\Referral;

class PayableRepositoryTest extends OrmTestCase
{
    public function testUserSummary()
    {
        $user = $this->createUserEntity(1);
        $this->em->persist($user);

        $payable1 = new Payable();
        $payable1->setUser($user);
        $payable1->setAmount(10);
        $payable1->setPending(10);
        $this->em->persist($payable1);

        $payable2 = new Payable();
        $payable2->setUser($user);
        $payable2->setAmount(10);
        $payable2->setAvailable(10);
        $this->em->persist($payable2);

        $payable3 = new Payable();
        $payable3->setUser($user);
        $payable3->setAmount(10);
        $payable3->setProcessing(10);
        $this->em->persist($payable3);

        $payable4 = new Payable();
        $payable4->setUser($user);
        $payable4->setAmount(10);
        $payable4->setPaid(10);
        $this->em->persist($payable4);

        $this->em->flush();
        $repo = $this->em->getRepository('App\Entity\Payable');
        $summary = $repo->calculateUserSummary($user);

        $this->assertTrue(is_array($summary));
        $this->assertArrayHasKey('amount', $summary);
        $this->assertArrayHasKey('pending', $summary);
        $this->assertArrayHasKey('available', $summary);
        $this->assertArrayHasKey('processing', $summary);
        $this->assertArrayHasKey('paid', $summary);

        $this->assertEquals(40, $summary['amount']);
        $this->assertEquals(10, $summary['pending']);
        $this->assertEquals(10, $summary['available']);
        $this->assertEquals(10, $summary['processing']);
        $this->assertEquals(10, $summary['paid']);
    }

    public function testMakeAvailable()
    {
        // payables are inmediately available
        $payable1 = new Payable();
        $payable1->setAmount(10.00);
        $payable1->setPending(10.00);
        $payable1->setRegisteredAt(new \DateTime());
        $this->em->persist($payable1);

        // cashback requires 90 days
        $cashback1 = new Cashback();
        $cashback1->setAmount(10.00);
        $cashback1->setPending(10.00);
        $cashback1->setRegisteredAt(new \DateTime());
        $this->em->persist($cashback1);

        $cashback2 = new Cashback();
        $cashback2->setAmount(10.00);
        $cashback2->setPending(10.00);
        $cashback2->setRegisteredAt(new \DateTime('90 days ago'));
        $this->em->persist($cashback2);

        // fix wrong cashback from previous bug, available amount was not set
        $cashback3 = new Cashback();
        $cashback3->setAmount(10.00);
        $cashback3->setPending(10.00);
        $cashback3->setRegisteredAt(new \DateTime('90 days ago'));
        $cashback3->setStatus(Cashback::STATUS_AVAILABLE);
        $this->em->persist($cashback3);

        // referrals need 90 days
        $referral1 = new Referral();
        $referral1->setAmount(10.00);
        $referral1->setPending(10.00);
        $referral1->setDirect(10.00);
        $referral1->setRegisteredAt(new \DateTime());
        $this->em->persist($referral1);

        $referral2 = new Referral();
        $referral2->setAmount(10.00);
        $referral2->setPending(10.00);
        $referral2->setDirect(10.00);
        $referral2->setRegisteredAt(new \DateTime('90 days ago'));
        $this->em->persist($referral2);

        $this->em->flush();
        $this->em->getRepository('App\Entity\Payable')->makeAvailable();

        $this->em->refresh($payable1);
        $this->assertEquals(10.00, $payable1->getAvailable(), 0.01);
        $this->assertEquals(Payable::STATUS_AVAILABLE, $payable1->getStatus());

        $this->em->refresh($cashback1);
        $this->assertEquals(10.00, $cashback1->getPending(), 0.01);
        $this->assertEquals(Cashback::STATUS_PENDING, $cashback1->getStatus());

        $this->em->refresh($cashback2);
        $this->assertEquals(10.00, $cashback2->getAvailable(), 0.01);
        $this->assertEquals(Cashback::STATUS_AVAILABLE, $cashback2->getStatus());

        $this->em->refresh($cashback3);
        $this->assertEquals(0.00, $cashback3->getPending(), 0.01);
        $this->assertEquals(10.00, $cashback3->getAvailable(), 0.01);
        $this->assertEquals(Cashback::STATUS_AVAILABLE, $cashback3->getStatus());

        $this->em->refresh($referral1);
        $this->assertEquals(10.00, $referral1->getPending(), 0.01);
        $this->assertEquals(Referral::STATUS_PENDING, $referral1->getStatus());

        $this->em->refresh($referral2);
        $this->assertEquals(10.00, $referral2->getAvailable(), 0.01);
        $this->assertEquals(Referral::STATUS_AVAILABLE, $referral2->getStatus());
    }
}
