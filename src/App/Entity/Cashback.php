<?php

namespace App\Entity;

/**
 * @Entity
 */
class Cashback extends Payable
{
    /**
     * @ManyToOne(targetEntity="Transaction", inversedBy="cashbacks")
     */
    protected $transaction;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $share = 0.00;

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
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

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;

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
