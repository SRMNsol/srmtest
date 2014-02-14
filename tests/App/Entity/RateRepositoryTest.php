<?php

use App\Tests\OrmTestCase;
use App\Entity\Transaction;
use App\Entity\Rate;
use App\Entity\RateRepository;

class RateRepositoryTest extends OrmTestCase
{
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

        // test if a default rate is created
        $rate = $repo->getCurrentRate();
        $this->assertInstanceOf('App\Entity\Rate', $rate);

        // test if we are not recreating default rate
        $rate2 = $repo->getCurrentRate();
        $this->assertEquals($rate2, $rate);
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
        $repo = $this->em->getRepository('App\Entity\Rate');

        $timeBefore = new DateTime();
        sleep(1);
        $defaultRate = $repo->createDefaultRate();
        sleep(1);
        $timeAfter = new DateTime();

        $transaction = new Transaction();
        $transaction->setRegisteredAt(new DateTime());
        $transaction->setOrderNumber('T123');
        $this->em->persist($transaction);
        $this->em->flush();

        $this->assertEquals($defaultRate, $transaction->getRate());

        sleep(1);
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

        // set back timestamp on before default rate
        // will assign default rate
        $transaction->setTag(sprintf('t%d', $timeBefore->format('U')));
        $this->em->flush();
        $this->assertEquals($defaultRate, $transaction->getRate());

        // set back timestamp after default rate
        // will assign default rate using subid
        $transaction->setTag(sprintf('t%d', $timeAfter->format('U')));
        $this->em->flush();
        $this->assertEquals($defaultRate, $transaction->getRate());

        // set timestamp to after new rate
        // will assign new rate
        $time = new DateTime();
        $transaction->setTag(sprintf('t%d', $time->format('U')));
        $this->em->flush();
        $this->assertEquals($newRate, $transaction->getRate());
    }
}
