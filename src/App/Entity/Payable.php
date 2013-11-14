<?php

namespace App\Entity;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="payableType")
 * @DiscriminatorMap({"payable"="Payable", "cashback"="Cashback"})
 */
class Payable
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="payables")
     * @JoinColumn(referencedColumnName="uid")
     */
    protected $user;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $amount = 0.00;

    /**
     * @Column(nullable=true)
     */
    protected $concept;

    /**
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @Column(length=20)
     */
    protected $status = self::STATUS_PENDING;

    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

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

    /**
     * @PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @PreUpdate
     */
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
                $this->status = self::STATUS_PENDING;
            }
        } else {
            $this->amount = 0.00;
        }

        return $this;
    }
}
