<?php

use App\Tests\OrmTestCase;
use App\Entity\Payable;

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
}
