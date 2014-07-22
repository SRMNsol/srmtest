<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="AdvertiserTransaction")
 * @ORM\HasLifecycleCallbacks
 * @ORM\EntityListeners({"TransactionListener"})
 */
class Transaction extends BaseTransaction
{
    /**
     * @ORM\ManyToOne(targetEntity="Cashback", inversedBy="transactions", cascade={"persist"})
     */
    protected $cashback;

    /**
     * @ORM\ManyToOne(targetEntity="Rate")
     */
    protected $rate;

    /**
     * Validation
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['orderNumber', 'merchant'],
            'message' => 'Order number exists for this merchant',
        ]));
        $metadata->addPropertyConstraint('merchant', new Assert\NotBlank());
        $metadata->addPropertyConstraint('orderNumber', new Assert\NotBlank());
        $metadata->addPropertyConstraint('registeredAt', new Assert\NotBlank());
    }

    public function getCashback()
    {
        return $this->cashback;
    }

    public function setCashback(Cashback $cashback = null)
    {
        $this->cashback = $cashback;

        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate(Rate $rate = null)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        return parent::onCreate();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        return parent::onUpdate();
    }
}
