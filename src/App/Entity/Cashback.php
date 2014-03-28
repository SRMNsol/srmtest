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
        $payment = 0.00;
        $adjustment = 0.00;
        $registeredAt = null;

        $method = "getLevel$rateLevel"; // getLevel0 -> getLevel7
        if (!method_exists('App\Entity\Rate', $method)) {
            throw new \RuntimeException("Invalid rate level $rateLevel");
        }

        foreach ($this->transactions as $transaction) {
            $rate = $transaction->getRate();
            $share = $rate ? $rate->$method() : 0;
            $total += $transaction->getTotal();

            if ($transaction->getCommission() > 0 && $share > 0) {
                $commission += $share * $transaction->getCommission();
                $payment += $share * $transaction->calculatePaymentSum();
                $adjustment += $share * $transaction->calculateAdjustmentSum();
                if (null === $registeredAt || $transaction->getRegisteredAt() > $registeredAt) {
                    $registeredAt = clone $transaction->getRegisteredAt();
                }
            }
        }

        return compact('total', 'commission', 'payment', 'adjustment', 'registeredAt');
    }

    public function calculateAmount()
    {
        // extract $total, $commission, $payment, $adjustment, $registeredAt
        extract($this->calculateTransactionValues());

        $this->amount = $commission - $adjustment;
        $this->available = $payment - $this->processing - $this->paid;
        $this->pending = $this->amount - $this->available;
        $this->registeredAt = $registeredAt;

        if ($this->amount > 0 && $total <= 0) {
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
