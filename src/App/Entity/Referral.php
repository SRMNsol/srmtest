<?php

namespace App\Entity;

/**
 * @Entity
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
}
