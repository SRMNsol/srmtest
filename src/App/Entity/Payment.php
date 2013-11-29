<?php

namespace App\Entity;

use Popshops\Payment as BasePayment;

/**
 * @Entity @HasLifecycleCallbacks
 */
class Payment extends BasePayment
{
    /**
     * @PrePersist @PreUpdate
     */
    public function updateTransaction()
    {
        parent::updateTransaction();
    }
}
