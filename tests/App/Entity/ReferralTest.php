<?php

use App\Entity\Referral;
use App\Tests\OrmTestCase;

class ReferralTest extends OrmTestCase
{
    /**
     * @expectedException Exception
     */
    public function testValidateAmountsOnSave()
    {
        $referral = new Referral();
        $referral->setPending(100);
        $referral->setAvailable(100);
        $referral->setProcessing(100);
        $referral->setPaid(100);
        $referral->setDirect(100);
        $referral->setAmount(333); // wrong sum
        $this->em->persist($referral);
        $this->em->flush();
    }

    /**
     * @expectedException Exception
     */
    public function testValidateDirectOnSave()
    {
        $referral = new Referral();
        $referral->setPending(100);
        $referral->setAmount(100);
        $referral->setDirect(333); // wrong sum
        $this->em->persist($referral);
        $this->em->flush();
    }

    /**
     * @expectedException Exception
     */
    public function testValidateIndirectOnSave()
    {
        $referral = new Referral();
        $referral->setPending(100);
        $referral->setAmount(100);
        $referral->setIndirect(333); // wrong sum
        $this->em->persist($referral);
        $this->em->flush();
    }

    public function testUpdateStatusCallback()
    {
        $referral = new Referral();
        $referral->setAmount(100);
        $referral->setPending(100);
        $referral->setDirect(100);
        $this->em->persist($referral);
        $this->em->flush();
        $this->assertEquals(Referral::STATUS_PENDING, $referral->getStatus());

        $referral->setPending(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Referral::STATUS_AVAILABLE, $referral->getStatus());

        $referral->setAvailable(0)->setProcessing(100);
        $this->em->flush();
        $this->assertEquals(Referral::STATUS_PROCESSING, $referral->getStatus());

        $referral->setProcessing(0)->setPaid(100);
        $this->em->flush();
        $this->assertEquals(Referral::STATUS_PAID, $referral->getStatus());

        $referral->setStatus(Referral::STATUS_INVALID);
        $referral->setPaid(0)->setAvailable(100);
        $this->em->flush();
        $this->assertEquals(Referral::STATUS_INVALID, $referral->getStatus());
    }

    public function testAvailableDateCallback()
    {
        $referral = new Referral();
        $referral->setRegisteredAt(new \DateTime());
        $this->em->persist($referral);
        $this->em->flush();
        $availDate = new \DateTime('+90 days');

        $this->assertEquals(
            $availDate->format('Y-m-d'),
            $referral->getAvailableAt()->format('Y-m-d')
        );
    }
}
