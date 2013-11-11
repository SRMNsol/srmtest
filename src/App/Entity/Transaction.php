<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;

class Transaction extends BaseTransaction
{
    protected $payable;

    public function getPayable()
    {
        return $this->payable;
    }

    public function setPayable(Payable $payable = null)
    {
        $this->payable = $payable;

        return $this;
    }
}
