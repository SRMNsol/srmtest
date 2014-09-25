<?php

use App\Tests\OrmTestCase;
use App\Entity\Referral;
use App\Entity\Transaction;
use App\Entity\User;

class ReferralRepositoryTest extends OrmTestCase
{
    public function setUp()
    {
        parent::setUp();

        // fixtures
        $user1 = $this->createUserEntity(1);
        $this->em->persist($user1);
        $user2 = $this->createUserEntity(2);
        $user2->setReferredBy($user1);
        $this->em->persist($user2);
        $user3 = $this->createUserEntity(3);
        $user3->setReferredBy($user2);
        $this->em->persist($user3);

        $this->em->flush();
        $this->em->clear();
    }

    public function testNoTransactionsReturn0()
    {
        $user = $this->em->find('App\Entity\User', 1);
        $referralRepository = $this->em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->createUserReferral($user, '01', '2014');
        $this->assertEquals(0, $referral->getAmount(), 0.01);
    }

    public function testDirectReferral()
    {
        $transact1 = new Transaction();
        $transact1->setRegisteredAt($regdate1 = new \DateTime('2014-02-01'));
        $transact1->setOrderNumber(123);
        $transact1->setTag('u2');
        $transact1->setTotal(100.00);
        $transact1->setCommission(10.00);
        $this->em->persist($transact1);
        $this->em->flush();

        $rate = $transact1->getRate();

        $user = $this->em->find('App\Entity\User', 1);
        $referralRepository = $this->em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->createUserReferral($user, '02', '2014');
        $this->assertEquals($rate->getLevel1() * $transact1->getCommission(), $referral->getAmount(), 0.01);

        $transact2 = new Transaction();
        $transact2->setRegisteredAt($regdate2 = new \DateTime('2014-02-02'));
        $transact2->setOrderNumber(123);
        $transact2->setTag('u2');
        $transact2->setTotal(200.00);
        $transact2->setCommission(20.00);
        $this->em->persist($transact2);
        $this->em->flush();

        $referral = $referralRepository->createUserReferral($user, '02', '2014');
        $this->assertEquals($rate->getLevel1() * ($transact1->getCommission() + $transact2->getCommission()), $referral->getAmount(), 0.01);
        $this->assertEquals($regdate2, $referral->getRegisteredAt());
    }

    public function testIndirectReferral()
    {
        $transact1 = new Transaction();
        $transact1->setRegisteredAt(new \DateTime('2014-02-01'));
        $transact1->setOrderNumber(123);
        $transact1->setTag('u3');
        $transact1->setTotal(100.00);
        $transact1->setCommission(10.00);
        $this->em->persist($transact1);
        $this->em->flush();

        $rate = $transact1->getRate();

        $user = $this->em->find('App\Entity\User', 1);
        $referralRepository = $this->em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->createUserReferral($user, '02', '2014');
        $this->assertEquals($rate->getLevel2() * $transact1->getCommission(), $referral->getAmount(), 0.01);
    }
}
