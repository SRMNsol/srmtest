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

    public function testUp()
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
    }
}
