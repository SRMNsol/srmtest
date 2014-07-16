<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="CashbackRepository")
 */
class Cashback extends Payable
{
    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="cashback")
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

    public function calculateAmountFromTransactions()
    {
        // when cashback is processing or paid, do not update
        if ($this->isLocked()) {
            return $this;
        }

        // extract $total, $commission, $registeredAt
        extract($this->calculateTransactionValues());

        $this->amount = $commission;
        $this->registeredAt = $registeredAt;
        $this->updateAvailableDate();

        // commission > 0 but total transaction amount = 0
        if ($this->amount >= 0.01 && $total <= 0.01) {
            $this->status = self::STATUS_INVALID;

            return $this;
        }

        // the only possible statuses are pending or available
        if ($this->availableAt <= new \DateTime()) {
            // past 90 days
            $this->available = $commission;
            $this->pending = 0.00;
        } else {
            // too recent
            $this->available = 0.00;
            $this->pending = $commission;
        }

        // status update will be handled by parent payable
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

    public function getTransactionNumbers()
    {
        $nums = [];

        foreach ($this->transactions as $transaction) {
            $nums[$transaction->getOrderNumber()] = 1;
        }

        return array_keys($nums);
    }

    public function getTransactionDate()
    {
        $date = null;

        foreach ($this->transactions as $transaction) {
            if ($date === null || $date > $transaction->getRegisteredAt()) {
                $date = clone $transaction->getRegisteredAt();
            }
        }

        return $date;
    }
}
