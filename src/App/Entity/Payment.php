<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Payment
{
    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $requestedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $paidAt;

    /**
     * @ORM\OneToMany(targetEntity="Payable", mappedBy="payment")
     */
    protected $payables;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payments")
     * @ORM\JoinColumn(referencedColumnName="uid")
     */
    protected $user;

    /**
     * @ORM\Column(length=20)
     */
    protected $status;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';

    public function __construct()
    {
        $this->payables = new ArrayCollection();
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
     * Set amount
     *
     * @param string $amount
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set requestedAt
     *
     * @param \DateTime $requestedAt
     * @return Payment
     */
    public function setRequestedAt($requestedAt)
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    /**
     * Get requestedAt
     *
     * @return \DateTime 
     */
    public function getRequestedAt()
    {
        return $this->requestedAt;
    }

    /**
     * Set paidAt
     *
     * @param \DateTime $paidAt
     * @return Payment
     */
    public function setPaidAt($paidAt)
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    /**
     * Get paidAt
     *
     * @return \DateTime 
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Payment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add payables
     *
     * @param \App\Entity\Payable $payables
     * @return Payment
     */
    public function addPayable(\App\Entity\Payable $payables)
    {
        $this->payables[] = $payables;

        return $this;
    }

    /**
     * Remove payables
     *
     * @param \App\Entity\Payable $payables
     */
    public function removePayable(\App\Entity\Payable $payables)
    {
        $this->payables->removeElement($payables);
    }

    /**
     * Get payables
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPayables()
    {
        return $this->payables;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Payment
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
