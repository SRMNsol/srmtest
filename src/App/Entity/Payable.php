<?php

namespace App\Entity;

class Payable
{
    protected $id;
    protected $user;
    protected $amount = 0.00;
    protected $concept;
    protected $transaction;
    protected $share;
    protected $createdAt;
    protected $updatedAt;
    protected $status = self::STATUS_INPROCESS;

    const STATUS_INPROCESS = 'inprocess';
    const STATUS_AVAILABLE = 'available';
    const STATUS_PAID = 'paid';
    const STATUS_INVALID = 'invalid';

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getConcept()
    {
        return $this->concept;
    }

    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

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
                $this->status = self::STATUS_INPROCESS;
            }
        } else {
            $this->amount = 0.00;
        }

        return $this;
    }
}
