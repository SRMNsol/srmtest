<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TransactionHistory
{
    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $registeredAt;

    /**
     * @ORM\ManyToOne(targetEntity="Transaction", inversedBy="history")
     */
    protected $transaction;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $itemNumber;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $total = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commission = 0.00;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;


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
     * Set registeredAt
     *
     * @param \DateTime $registeredAt
     * @return TransactionHistory
     */
    public function setRegisteredAt($registeredAt)
    {
        if ($registeredAt instanceof \DateTime && $this->registeredAt instanceof \DateTime) {
            if ($this->registeredAt->format('YmdHis') !== $registeredAt->format('YmdHis')) {
                $this->registeredAt = $registeredAt;
            }

            return $this;
        }

        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Get registeredAt
     *
     * @return \DateTime
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set itemNumber
     *
     * @param string $itemNumber
     * @return TransactionHistory
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;

        return $this;
    }

    /**
     * Get itemNumber
     *
     * @return string
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return TransactionHistory
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set commission
     *
     * @param string $commission
     * @return TransactionHistory
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TransactionHistory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return TransactionHistory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set transaction
     *
     * @param Transaction $transaction
     * @return TransactionHistory
     */
    public function setTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
