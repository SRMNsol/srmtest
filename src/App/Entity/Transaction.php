<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;

/**
 * @Entity
 * @Table(name="AdvertiserTransaction")
 * @HasLifecycleCallbacks
 * @EntityListeners({"TransactionListener"})
 */
class Transaction extends BaseTransaction
{
    /**
     * @ManyToOne(targetEntity="Cashback", inversedBy="transactions", cascade={"persist"})
     */
    protected $cashback;

    /**
     * @ManyToOne(targetEntity="Rate")
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
     * @PrePersist
     */
    public function onCreate()
    {
        return parent::onCreate();
    }

    /**
     * @PreUpdate
     */
    public function onUpdate()
    {
        return parent::onUpdate();
    }
}
