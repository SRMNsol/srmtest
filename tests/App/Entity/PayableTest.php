<?php

use App\Entity\Payable;
use App\Tests\OrmTestCase;

class PayableTest extends OrmTestCase
{
    /**
     * @expectedException Exception
     */
    public function testValidateAmountsOnSave()
    {
        $payable = new Payable();
        $payable->setPending(100);
        $payable->setAvailable(100);
        $payable->setProcessing(100);
        $payable->setPaid(100);
        $payable->setAmount(333); // wrong sum
        $this->em->persist($payable);
        $this->em->flush();
    }

    public function testUpdateStatusCallback()
    {
        $payable = new Payable();
        $payable->setAmount(100);
        $payable->setPending(100);
        $this->em->persist($payable);
        $this->em->flush();
        $this->assertEquals(Payable::STATUS_PENDING, $payable->getStatus());

        $payable->setPending(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Payable::STATUS_AVAILABLE, $payable->getStatus());

        $payable->setAvailable(0)->setProcessing(100);
        $this->em->flush();
        $this->assertEquals(Payable::STATUS_PROCESSING, $payable->getStatus());

        $payable->setProcessing(0)->setPaid(100);
        $this->em->flush();
        $this->assertEquals(Payable::STATUS_PAID, $payable->getStatus());

        $payable->setStatus(Payable::STATUS_INVALID);
        $payable->setPaid(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Payable::STATUS_INVALID, $payable->getStatus());
    }

    public function testAvailableDateCallback()
    {
        $payable = new Payable();
        $payable->setRegisteredAt(new \DateTime());
        $this->em->persist($payable);
        $this->em->flush();
        $this->assertEquals($payable->getRegisteredAt()->format('Y-m-d'), $payable->getAvailableAt()->format('Y-m-d'));
    }
}
