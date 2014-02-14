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
        $user1 = $this->createUser(1);
        $this->em->persist($user1);
        $user2 = $this->createUser(1);
        $user2->setReferredBy($user1);
        $this->em->persist($user2);
        $user3 = $this->createUser(3);
        $user3->setReferredBy($user2);
        $this->em->persist($user3);

        $this->em->flush();
        $this->em->clear();
    }

    protected function createUser($i)
    {
        $user = new User();
        $user->setEmail("$i@example.com");
        $user->setPaymentMethod('x');
        $user->setPaypalEmail("$i@example.com");
        $user->setAlias("user");
        $user->setExtrabuxCharityId(99);
        $user->setLastLoginAt(new \DateTime());
        $user->setLastReferAt(new \DateTime());
        $user->setCreatedAt(new \DateTime());
        $user->setFacebookAccessToken("test");
        $user->setTwitterTokenSecret("test");
        $user->setTwitterAccessToken("test");
        $user->setPassword("Pa55w0rd");
        $user->setLastCashbackAt(new \DateTime());

        return $user;
    }

    public function testNoTransactionsReturn0()
    {
        $user = $this->em->find('App\Entity\User', 1);
        $referralRepository = $this->em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->calculateUserReferral($user, '01', '2014');
        $this->assertEquals(0, $referral->getAmount());
    }

    public function testDirectReferral()
    {
        $transact1 = new Transaction();
        $transact1->setRegisteredAt(new \DateTime());
        $transact1->setOrderNumber(123);
        $transact1->setTag('u2');
        $transact1->setTotal(100.00);
        $transact1->setCommission(10.00);
        $this->em->persist($transact1);
        $this->em->flush();

        $rate = $transact1->getRate();

        $user = $this->em->find('App\Entity\User', 1);
        $referralRepository = $this->em->getRepository('App\Entity\Referral');
        $referral = $referralRepository->calculateUserReferral($user, date('m'), date('Y'));
        $this->assertEquals($rate->getLevel1() * $transact1->getCommission(), $referral->getAmount());

        $transact2 = new Transaction();
        $transact2->setRegisteredAt(new \DateTime());
        $transact2->setOrderNumber(123);
        $transact2->setTag('u2');
        $transact2->setTotal(200.00);
        $transact2->setCommission(20.00);
        $this->em->persist($transact2);
        $this->em->flush();

        $referral = $referralRepository->calculateUserReferral($user, date('m'), date('Y'));
        $this->assertEquals($rate->getLevel1() * ($transact1->getCommission() + $transact2->getCommission()), $referral->getAmount());
    }
}
