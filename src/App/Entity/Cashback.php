<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="CashbackRepository")
 */
class Cashback extends Payable
{
    /**
     * @OneToMany(targetEntity="Transaction", mappedBy="cashback")
     */
    protected $transactions;

    const AVAILABLE_DAYS = 90;

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
        $transaction->setCashback($this);

        return $this;
    }

    public function removeTransaction(Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
        $transaction->setCashback(/* null */);

        return $this;
    }

    public function calculateTransactionValues($rateLevel = 0)
    {
        $total = 0.00;
        $commission = 0.00;
        $registeredAt = null;

        $method = "getLevel$rateLevel"; // getLevel0 -> getLevel7
        if (!method_exists('App\Entity\Rate', $method)) {
            throw new \RuntimeException("Invalid rate level $rateLevel");
        }

        foreach ($this->transactions as $transaction) {
            $rate = $transaction->getRate();
            $share = $rate ? $rate->$method() : 0;
            $total += $transaction->getTotal();

            if ($transaction->getRealCommission() >= 0.01 && $share >= 0.01) {
                $commission += $share * $transaction->getRealCommission();
                if (null === $registeredAt || $transaction->getRegisteredAt() > $registeredAt) {
                    $registeredAt = clone $transaction->getRegisteredAt();
                }
            }
        }

        return compact('total', 'commission', 'registeredAt');
    }

    public function calculateAmount()
    {
        // if cashback is locked don't update
        if ($this->isLocked()) {
            return $this;
        }

        // extract $total, $commission, $registeredAt
        extract($this->calculateTransactionValues());

        $this->registeredAt = $registeredAt;
        $this->updateAvailableDate();

        $this->amount = $commission;

        // past 90 days
        if ($this->availableAt <= new \DateTime()) {
            $this->available = $commission;
            $this->pending = 0.00;
            $this->status = self::STATUS_AVAILABLE;
        } else {
            $this->available = 0.00;
            $this->pending = $commission;
            $this->status = self::STATUS_PENDING;
        }

        if ($this->amount >= 0.01 && $total <= 0.01) {
            $this->status = self::STATUS_INVALID;
        }

        return $this;
    }

    public function calculateTransactionTotal()
    {
        $total = 0.00;
        foreach ($this->transactions as $transaction) {
            $total += $transaction->getTotal();
        }

        return $total;
    }
}
