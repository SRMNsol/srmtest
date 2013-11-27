<?php

namespace App\Entity;

/**
 * @Entity
 */
class Summary
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

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
     * @OneToOne(targetEntity="User", inversedBy="summary")
     * @JoinColumn(referencedColumnName="uid")
     */
    protected $user;

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
     * @return Summary
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
     * @return Summary
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
     * @return Summary
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
     * @return Summary
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
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Summary
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
