<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;
use Doctrine\ORM\Mapping as ORM;

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
