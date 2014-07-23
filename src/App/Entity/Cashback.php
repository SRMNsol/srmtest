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
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="cashback")
     * @ORM\OrderBy({"registeredAt" = "ASC"})
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

    /**
     * Calculate total, commission using assigned rate,
     * and first registered date from transactions.
     *
     * Transactions are order by registered date ASC
     */
    public function calculateTransactionValues($rateLevel = 0)
    {
        return [
            'total' => $this->calculateTransactionTotal(),
            'commission' => $this->getCommissionTotalByLevel($rateLevel),
            'registeredAt' => $this->getTransactionDate(),
        ];
    }

    /**
     * Calculate cashback amount from transactions
     */
    public function calculateAmountFromTransactions()
    {
        // when cashback is processing or paid, do not update
        if ($this->isLocked()) {
            return $this;
        }

        $this->amount = $this->getCommissionTotalByLevel(0);
        $this->registeredAt = $this->getTransactionDate();
        $this->updateAvailableDate();

        // commission > 0 but total transaction amount = 0
        if (self::gt($this->amount, 0) && self::eq($this->calculateTransactionTotal(), 0)) {
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

    public function calculateTransactionTotal()
    {
        $total = 0.00;
        foreach ($this->transactions as $transaction) {
            $total += $transaction->getTotal();
        }

        return $total;
    }

    /**
     * Get a list of unique transaction (order) numbers
     */
    public function getTransactionNumbers()
    {
        $nums = [];

        foreach ($this->transactions as $transaction) {
            $nums[$transaction->getOrderNumber()] = 1;
        }

        return array_keys($nums);
    }

    /**
     * Get the earliest transaction date
     * Transactions are order by registered date ASC
     */
    public function getTransactionDate()
    {
        if ($this->transactions->count() > 0) {
            return $this->transactions->first()->getRegisteredAt();
        }

        return null;
    }

    /**
     * Calculate commissions by rate
     */
    public function getCommissionTotalByLevel($rateLevel)
    {
        $commission = 0;

        $method = "getLevel$rateLevel"; // getLevel0 -> getLevel7
        if (!method_exists('App\Entity\Rate', $method)) {
            throw new \RuntimeException("Invalid rate level $rateLevel");
        }

        foreach ($this->transactions as $transaction) {
            $rate = $transaction->getRate();
            $share = $rate ? $rate->$method() : 0;

            if (self::gt($transaction->getRealCommission(), 0) && self::gt($share, 0)) {
                $commission += $share * $transaction->getRealCommission();
            }
        }

        return $commission;
    }
}
