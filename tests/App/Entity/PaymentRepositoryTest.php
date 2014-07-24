<?php

use App\Entity\Payment;
use App\Entity\Payable;
use App\Entity\Cashback;
use App\Entity\Referral;
use App\Tests\OrmTestCase;

class PaymentRepositoryTest extends OrmTestCase
{
    public function testCreatePaymentForUser()
    {
        $user1 = $this->createUserEntity(1);
        $this->em->persist($user1);

        $user2 = $this->createUserEntity(2);
        $this->em->persist($user2);

        // included
        $payable1 = new Payable();
        $payable1->setAmount(10.00);
        $payable1->setAvailable(10.00);
        $payable1->setRegisteredAt(new \DateTime());
        $payable1->setUser($user1);
        $this->em->persist($payable1);

        // not included
        $payable2 = new Payable();
        $payable2->setAmount(10.00);
        $payable2->setPending(10.00);
        $payable2->setRegisteredAt(new \DateTime());
        $payable2->setUser($user1);
        $this->em->persist($payable2);

        // included
        $cashback1 = new Cashback();
        $cashback1->setAmount(10.00);
        $cashback1->setAvailable(10.00);
        $cashback1->setRegisteredAt(new \DateTime('90 days ago'));
        $cashback1->setUser($user1);
        $this->em->persist($cashback1);

        // not included
        $cashback2 = new Cashback();
        $cashback2->setAmount(10.00);
        $cashback2->setPending(10.00);
        $cashback2->setRegisteredAt(new \DateTime());
        $cashback2->setUser($user1);
        $this->em->persist($cashback2);

        // included
        $referral1 = new Referral();
        $referral1->setAmount(10.00);
        $referral1->setAvailable(10.00);
        $referral1->setDirect(10.00);
        $referral1->setRegisteredAt(new \DateTime('90 days ago'));
        $referral1->setUser($user1);
        $this->em->persist($referral1);

        // not included
        $referral2 = new Referral();
        $referral2->setAmount(10.00);
        $referral2->setPending(10.00);
        $referral2->setDirect(10.00);
        $referral2->setRegisteredAt(new \DateTime());
        $referral2->setUser($user1);
        $this->em->persist($referral2);

        // not included, for user2
        $payable3 = new Payable();
        $payable3->setAmount(10.00);
        $payable3->setAvailable(10.00);
        $payable3->setRegisteredAt(new \DateTime());
        $payable3->setUser($user2);
        $this->em->persist($payable3);

        $this->em->flush();
        $this->em->refresh($user1);

        $payment = $this->em->getRepository('App\Entity\Payment')->createPaymentForUser($user1);
        $this->assertEquals(30.00, $payment->getAmount(), 0.01);

        $this->em->refresh($payable1);
        $this->assertEquals($payable1->getPayment(), $payment);
        $this->assertEquals($payable1->getAmount(), $payable1->getProcessing());
        $this->assertEquals(Payable::STATUS_PROCESSING, $payable1->getStatus());
    }
}
