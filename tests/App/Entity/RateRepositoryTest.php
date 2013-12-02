<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Rate;
use App\Entity\RateRepository;

class RateRepositoryTest extends OrmTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->createSchema(['App\Entity\Rate']);
    }

    public function testCreateDefaultRate()
    {
        $repo = $this->em->getRepository('App\Entity\Rate');
        $rate = $repo->createDefaultRate();

        $this->assertInstanceOf('App\Entity\Rate', $rate);
        $this->assertGreaterThan(0, $rate->getId());
        $this->assertEquals(0.5, $rate->getLevel0());
        $this->assertEquals(0.1, $rate->getLevel1());
        $this->assertEquals(0.05, $rate->getLevel2());
        $this->assertEquals(0.05, $rate->getLevel3());
        $this->assertEquals(0.05, $rate->getLevel4());
        $this->assertEquals(0.05, $rate->getLevel5());
        $this->assertEquals(0.05, $rate->getLevel6());
        $this->assertEquals(0.05, $rate->getLevel7());
    }

    public function testAutomaticallyCreateDefaultRate()
    {
        $repo = $this->em->getRepository('App\Entity\Rate');
        $rate = $repo->getCurrentRate();
        $this->assertInstanceOf('App\Entity\Rate', $rate);
    }

    public function testGetCurrentRate()
    {
        $repo = $this->em->getRepository('App\Entity\Rate');
        $rate = $repo->createDefaultRate();

        $current = $repo->getCurrentRate();
        $this->assertEquals($rate, $current);

        $newRate = new Rate();
        $newRate->setLevel0(0.6);
        $newRate->setLevel1(0.6);
        $newRate->setLevel2(0.6);
        $newRate->setLevel3(0.6);
        $newRate->setLevel4(0.6);
        $newRate->setLevel5(0.6);
        $newRate->setLevel6(0.6);
        $newRate->setLevel7(0.6);
        $this->em->persist($newRate);
        $this->em->flush();

        $current = $repo->getCurrentRate();
        $this->assertEquals($newRate, $current);
    }

    public function testFindRateForTransaction()
    {
        $this->createSchema(['App\Entity\Transaction']);
        $repo = $this->em->getRepository('App\Entity\Rate');
        $defaultRate = $repo->createDefaultRate();

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertEquals($defaultRate, $transaction->getRate());

        $newRate = new Rate();
        $newRate->setLevel0(0.6);
        $newRate->setLevel1(0.6);
        $newRate->setLevel2(0.6);
        $newRate->setLevel3(0.6);
        $newRate->setLevel4(0.6);
        $newRate->setLevel5(0.6);
        $newRate->setLevel6(0.6);
        $newRate->setLevel7(0.6);
        $this->em->persist($newRate);
        $this->em->flush();

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertEquals($newRate, $transaction->getRate());
    }
}
