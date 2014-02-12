<?php

namespace App\Entity;

/**
 * @Entity(repositoryClass="ReferralRepository")
 * @HasLifecycleCallbacks
 */
class Referral extends Payable
{
    /**
     * @Column(type="decimal", scale=2)
     */
    protected $direct = 0.00;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $indirect = 0.00;

    /**
     * @Column(length=6, nullable=true)
     */
    protected $month;

    /**
     * Set direct
     *
     * @param string $direct
     * @return Referral
     */
    public function setDirect($direct)
    {
        $this->direct = $direct;

        return $this;
    }

    /**
     * Get direct
     *
     * @return string
     */
    public function getDirect()
    {
        return $this->direct;
    }

    /**
     * Set indirect
     *
     * @param string $indirect
     * @return Referral
     */
    public function setIndirect($indirect)
    {
        $this->indirect = $indirect;

        return $this;
    }

    /**
     * Get indirect
     *
     * @return string
     */
    public function getIndirect()
    {
        return $this->indirect;
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set month
     *
     * @param string $month
     * @return string
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @PrePersist @PreUpdate
     */
    public function validateReferralAmounts()
    {
        $sum = $this->direct + $this->indirect;
        if (round($this->amount, 2) != round($sum, 2)) {
            throw new \Exception(sprintf('Invalid referral sum %.2f (expected %.2f)', $sum, $this->amount));
        }
    }
}
