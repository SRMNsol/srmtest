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
        $commission = 0.00;
        $payment = 0.00;
        $adjustment = 0.00;
        $availableAt = null;

        $method = "getLevel$rateLevel"; // getLevel0 -> getLevel7
        if (!method_exists($rate, $method)) {
            throw new \RuntimeException("Invalid rate level $rateLevel");
        }

        foreach ($this->transactions as $transaction) {
            $rate = $transaction->getRate();
            $share = $rate ? $rate->$method() : 0;

            if ($transaction->getCommission() > 0 && $share > 0) {
                $commission += $share * $transaction->getCommission();
                $payment += $share * $transaction->calculatePaymentSum();
                $adjustment += $share * $transaction->calculateAdjustmentSum();
                if (null === $availableAt || $transaction->getRegisteredAt() > $availableAt) {
                    $availableAt = clone $transaction->getRegisteredAt();
                }
            }
        }

        return compact('commission', 'payment', 'adjustment', 'availableAt');
    }

    public function calculateAmount()
    {
        // extract $commission, $payment, $adjustment, $availableAt
        extract($this->calculateTransactionValues());

        $this->amount = $commission - $adjustment;
        $this->available = $payment - $this->processing - $this->paid;
        $this->pending = $this->amount - $this->available;
        $this->availableAt = $availableAt->add(\DateInterval::createFromDateString('90 days'));

        return $this;
    }
}
