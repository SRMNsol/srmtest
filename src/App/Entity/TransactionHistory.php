<?php

namespace App\Entity;

use Popshops\TransactionHistory as BaseTransactionHistory;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class TransactionHistory extends BaseTransactionHistory
{
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
