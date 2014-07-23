<?php

use App\Tests\OrmTestCase;
use App\Entity\Referral;
use App\Entity\Transaction;
use App\Entity\User;

class CashbackRepositoryTest extends OrmTestCase
{
    protected function createUser($i)
    {
        $user = new User();
        $user->setEmail("$i@example.com");
        $user->setPaymentMethod('x');
        $user->setPaypalEmail("$i@example.com");
        $user->setAlias("user");
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

    public function testFindCashbackForUser()
    {
        $user = $this->createUser(1);
        $this->em->persist($user);
        $this->em->flush();

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new \DateTime('2014-02-01'));
        $transaction->setOrderNumber(123);
        $transaction->setTag('u1');
        $transaction->setTotal(100.00);
        $transaction->setCommission(10.00);
        $this->em->persist($transaction);
        $this->em->flush();

        $user = $this->em->find('App\Entity\User', 1);
        $cashbackRepository = $this->em->getRepository('App\Entity\Cashback');
        $cashbacks = $cashbackRepository->findCashbackForUser($user, '02', '2014');
        $this->assertTrue($cashbacks[0] === $transaction->getCashback());
    }
}
