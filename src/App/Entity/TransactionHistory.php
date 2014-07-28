<?php

namespace App\Entity;

use Popshops\TransactionHistory as BaseTransactionHistory;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TransactionHistory extends BaseTransactionHistory
{
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
