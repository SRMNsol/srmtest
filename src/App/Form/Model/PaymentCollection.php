<?php

namespace App\Form\Model;

class PaymentCollection
{
    protected $payments;

    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    public function getPayments()
    {
        return $this->payments;
    }
}
