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
     * @Column(type="decimal", scale=2)
     */
    protected $share = 0.00;

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

    public function getShare()
    {
        return $this->share;
    }

    public function setShare($share)
    {
        $this->share = $share;

        return $this;
    }

    public function calculateAmount()
    {
        if (null !== $this->transaction) {
            if ($this->transaction->getPayment() > 0) {
                $this->amount = $this->share * $this->transaction->getPayment();
                $this->status = self::STATUS_AVAILABLE;
            } elseif ($this->transaction->getCommission() > 0) {
                $this->amount = $this->share * $this->transaction->getCommission();
                $this->status = self::STATUS_PENDING;
            }
        } else {
            $this->amount = 0.00;
        }

        return $this;
    }

}
