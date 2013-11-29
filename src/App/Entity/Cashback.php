<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Cashback extends Payable
{
    /**
     * @OneToMany(targetEntity="Transaction", mappedBy="cashback")
     */
    protected $transactions;

    /**
     * @Column(type="datetime", nullable=false)
     */
    protected $availableAt;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    public function removeTransaction(Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    public function setAvailableAt(\DateTime $date)
    {
        $this->availableAt = $date;

        return $this;
    }

    public function calculateAmount()
    {
        $commission = 0.00;
        $payment = 0.00;
        $adjustment = 0.00;

        foreach ($this->transactions as $transaction) {
            $commission += $transaction->getCommission();
            $payment += $transaction->calculatePaymentSum();
            $adjustment += $transaction->calculateAdjustmentSum();
        }

        $this->total = $commission - $adjustment;
        $this->available = $payment - $this->paid;
        $this->pending = $commission - $adjustment - $payment;

        return $this;
    }
}
