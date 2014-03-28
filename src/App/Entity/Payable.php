<?php

namespace App\Entity;

/**
 * @Entity(repositoryClass="PayableRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="payableType")
 * @DiscriminatorMap({"payable"="Payable", "cashback"="Cashback", "referral" = "Referral"})
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
     * @Column(type="decimal", scale=2)
     */
    protected $pending = 0.00;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $available = 0.00;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $processing = 0.00;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $paid = 0.00;

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
     * @Column(type="datetime", nullable=true)
     */
    protected $registeredAt;

    /**
     * @Column(type="date", nullable=true)
     */
    protected $availableAt;

    /**
     * @Column(length=20)
     */
    protected $status = self::STATUS_PENDING;

    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_MIXED = 'mixed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_INVALID = 'invalid';

    const AVAILABLE_DAYS = 0;

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

    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;

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

    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    public function setAvailableAt(\DateTime $date)
    {
        $this->availableAt = $date;

        return $this;
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pending
     *
     * @param string $pending
     * @return Payable
     */
    public function setPending($pending)
    {
        $this->pending = $pending;

        return $this;
    }

    /**
     * Get pending
     *
     * @return string
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * Set available
     *
     * @param string $available
     * @return Payable
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return string
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set processing
     *
     * @param string $processing
     * @return Payable
     */
    public function setProcessing($processing)
    {
        $this->processing = $processing;

        return $this;
    }

    /**
     * Get processing
     *
     * @return string
     */
    public function getProcessing()
    {
        return $this->processing;
    }

    /**
     * Set paid
     *
     * @param string $paid
     * @return Payable
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return string
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validateAmounts()
    {
        $sum = $this->pending + $this->available + $this->processing + $this->paid;
        if (round($this->amount, 2) !== round($sum, 2)) {
            throw new \Exception(sprintf('Invalid sum amounts %.2f (expected %.2f)', $sum, $this->amount));
        }
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function updateStatusBasedOnAmounts()
    {
        if ($this->status === self::STATUS_INVALID) {
            return;
        }

        $status = null;
        foreach (['pending', 'available', 'processing', 'paid'] as $prop) {
            if ($this->$prop > 0) {
                if ($status !== null) {
                    $status = self::STATUS_MIXED;
                    break;
                } else {
                    $status = constant('self::STATUS_' . strtoupper($prop));
                }
            }
        }

        if ($status === null) {
            $this->status = self::STATUS_CANCELLED;
        } else {
            $this->status = $status;
        }
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function updateAvailableDate()
    {
        if (isset($this->registeredAt)) {
            $this->availableAt = clone $this->registeredAt;
            $this->availableAt->add(\DateInterval::createFromDateString(sprintf('%d days', static::AVAILABLE_DAYS)));
        }
    }
}
