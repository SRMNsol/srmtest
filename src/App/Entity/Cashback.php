<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="CashbackRepository")
 */
class Cashback extends Payable
{
    use MoneyTrait;

    /**
     * @ORM\OneToOne(targetEntity="Transaction", mappedBy="cashback")
     */
    protected $transaction;

    const AVAILABLE_DAYS = 90;

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;
        $transaction->setCashback($this);

        return $this;
    }

    /**
     * Calculate cashback amount from transactions
     */
    public function calculateAmounts()
    {
        // when cashback is processing or paid, do not update
        if ($this->isLocked()) {
            return $this;
        }

        $this->amount = $this->getCommissionShare(0);
        $this->registeredAt = $this->getTransactionDate();
        $this->updateAvailableDate();

        // commission > 0 but total transaction amount = 0
        if (self::gt($this->amount, 0) && self::eq($this->getTransactionTotal(), 0)) {
            $this->status = self::STATUS_INVALID;
            return $this;
        }

        // the only possible statuses are pending or available
        if ($this->availableAt <= new \DateTime()) {
            // past 90 days
            $this->available = $this->amount;
            $this->pending = 0.00;
        } else {
            // too recent
            $this->available = 0.00;
            $this->pending = $this->amount;
        }

        // status update will be handled by parent payable
        return $this;
    }

    /**
     * Get total purchase
     */
    public function getTotalPurchase()
    {
        return $this->transaction ? $this->transaction->getTotal() : 0.00;
    }

    /**
     * Get transaction order number
     */
    public function getOrderNumber()
    {
        return $this->transaction ? $this->transaction->getOrderNumber() : null;
    }

    /**
     * Get transaction date
     */
    public function getTransactionDate()
    {
        return $this->transaction ? $this->transaction->getRegisteredAt() : null;
    }

    /**
     * Get commission for level 0
     */
    public function getCommissionShare()
    {
        return $this->transaction ? $this->transaction->getCommissionByLevel(0) : 0.00;
    }
}
