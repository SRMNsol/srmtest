<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Merchant;
use App\Entity\Subid;

class TransactionListenerTest extends OrmTestCase
{
    public function testRateCreation()
    {
        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $rate = $transaction->getRate();
        $this->assertNotNull($rate);
    }

    public function testCashbackCreation()
    {
        $user = $this->createUserEntity(1);
        $this->em->persist($user);
        $this->em->flush();

        $subid = new Subid();
        $subid->setUserId($user->getId());

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime('yesterday'));
        $transaction->setOrderNumber('T123');
        $transaction->setTotal(50.00);
        $transaction->setCommission(5.00);
        $transaction->setTag((string) $subid);

        $merchant = new Merchant();
        $merchant->setId(123);
        $merchant->setName('Test');
        $merchant->setNetworkMerchantId('123');
        $merchant->setUrl('http://');
        $this->em->persist($merchant);

        $transaction->setMerchant($merchant);

        $this->em->persist($transaction);
        $this->em->flush();

        $cashback = $transaction->getCashback();
        $this->em->refresh($cashback);
        $this->assertNotNull($cashback);
        $this->assertEquals('pending', $cashback->getStatus());
        $this->assertEquals(2.50, $cashback->getAmount());

        // check user last purchased date on persist
        $this->em->refresh($user);
        $this->assertEquals(
            $cashback->getRegisteredAt()->format('Y-m-d'),
            $user->getLastCashbackAt()->format('Y-m-d')
        );

        // check user last purchased date on update
        $transaction->setRegisteredAt(new \DateTime());
        $this->em->flush();
        $this->em->refresh($cashback);
        $this->em->refresh($user);
        $this->assertEquals(
            $cashback->getRegisteredAt()->format('Y-m-d'),
            $user->getLastCashbackAt()->format('Y-m-d')
        );

        // updating will use the same cashback
        $transaction->setOrderNumber('T234');
        $transaction->setCommission(6.00);
        $this->em->flush();
        $this->em->refresh($cashback);
        $this->assertEquals($cashback, $transaction->getCashback());
        $this->assertEquals('Test', $cashback->getConcept());
        $this->assertEquals($transaction->getRegisteredAt()->format('Y-m-d'), $cashback->getRegisteredAt()->format('Y-m-d'));
        $this->assertEquals(3.00, $cashback->getAmount());

        // zero value is pending until 90 days
        $transaction->setCommission(0.00);
        $this->em->flush();
        $this->em->refresh($cashback);
        $this->assertEquals(0, $cashback->getAmount());
        $this->assertEquals('pending', $cashback->getStatus());

        // after 90 days, cashback status is updated
        $transaction->setRegisteredAt(new \DateTime('90 days ago'));
        $this->em->flush();
        $this->em->refresh($cashback);
        $this->assertEquals('canceled', $cashback->getStatus());

        $transaction->setCommission(123.00);
        $this->em->flush();
        $this->em->refresh($cashback);
        $this->assertEquals('available', $cashback->getStatus());
    }
}
