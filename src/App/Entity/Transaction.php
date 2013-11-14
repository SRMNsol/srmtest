<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;

/**
 * @Entity @HasLifecycleCallbacks
 */
class Transaction extends BaseTransaction
{
    /**
     * @ManyToOne(targetEntity="Cashback", inversedBy="transactions")
     */
    protected $cashback;

    public function getCashback()
    {
        return $this->cashback;
    }

    public function setCashback(Cashback $cashback = null)
    {
        $this->cashback = $cashback;

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
