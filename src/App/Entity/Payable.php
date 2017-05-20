<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PayableRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"registeredAt"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="payableType")
 * @ORM\DiscriminatorMap({"payable"="Payable", "cashback"="Cashback", "referral" = "Referral"})
 */
class Payable
{
    use MoneyTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payables")
     * @ORM\JoinColumn(referencedColumnName="uid")
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $pending = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $available = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $processing = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $paid = 0.00;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $concept;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $registeredAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $availableAt;

    /**
     * @ORM\Column(length=20)
     */
    protected $status = self::STATUS_PENDING;

    /**
     * @ORM\ManyToOne(targetEntity="Payment", inversedBy="payables")
     */
    protected $payment;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isExtrabux = false;

    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_MIXED = 'mixed';
    const STATUS_CANCELED = 'canceled';
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
     * Validate if sum is correct
     */
    public function validateAmounts()
    {
        $sum = $this->pending + $this->available + $this->processing + $this->paid;
        if (!self::eq($this->amount, $sum)) {
            throw new \Exception(sprintf('Invalid sum amounts %.2f (expected %.2f)', $sum, $this->amount));
        }
    }

    /**
     * Set status based on amount types
     */
    public function updateStatusBasedOnAmounts()
    {
        if ($this->status === self::STATUS_INVALID) {
            return $this;
        }

        $status = null;
        foreach (['pending', 'available', 'processing', 'paid'] as $prop) {
            if (self::gt($this->$prop, 0)) {
                if ($status !== null) {
                    $status = self::STATUS_MIXED;
                    break;
                } else {
                    $status = constant('self::STATUS_' . strtoupper($prop));
                }
            }
        }

        // when all amounts are 0, $status is null
        if ($status === null) {
            if ($this->availableAt <= new \DateTime()) {
                $this->status = self::STATUS_CANCELED;
            } else {
                $this->status = self::STATUS_PENDING;
            }
        } else {

            $this->status = $status;

            
			

			
        }
    }

    public function updateAvailableDate()
    {
        if (isset($this->registeredAt)) {
            $this->availableAt = clone $this->registeredAt;
            $this->availableAt->add(\DateInterval::createFromDateString(sprintf('%d days', static::AVAILABLE_DAYS)));
        }
    }

    public function isLocked()
    {
        return $this->status === self::STATUS_PROCESSING
            || $this->status === self::STATUS_PAID;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist @ORM\PreUpdate
     */
    public function onSave()
    {
        $this->validateAmounts();
        $this->updateAvailableDate();
        $this->updateStatusBasedOnAmounts();
    }

    /**
     * Set payment
     *
     * @param \App\Entity\Payment $payment
     * @return Payable
     */
    public function setPayment(\App\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \App\Entity\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set isExtrabux
     *
     * @param boolean $isExtrabux
     * @return Payable
     */
    public function setIsExtrabux($isExtrabux)
    {
        $this->isExtrabux = $isExtrabux;

        return $this;
    }

    /**
     * Get isExtrabux
     *
     * @return boolean
     */
    public function getIsExtrabux()
    {
        return $this->isExtrabux;
    }

    /**
     * Return payment date if is paid
     */
    public function getPaymentDate()
    {
        if ($this->payment !== null && $this->payment->getPaidAt() !== null) {
            return $this->payment->getPaidAt();
        }

        return null;
    }
}
