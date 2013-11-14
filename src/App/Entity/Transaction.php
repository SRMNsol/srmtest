<?php

namespace App\Entity;

use Popshops\Transaction as BaseTransaction;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Transaction extends BaseTransaction
{
    /**
     * @OneToMany(targetEntity="Cashback", mappedBy="transaction")
     */
    protected $cashbacks;

    public function __construct()
    {
        parent::__construct();

        $this->cashbacks = new ArrayCollection();
    }

    public function getCashbacks()
    {
        return $this->cashbacks;
    }

    public function addCashback(Cashback $cashback)
    {
        $this->cashbacks[] = $cashback;

        return $this;
    }

    public function removeCashback(Cashback $cashback)
    {
        $this->cashbacks->removeElement($cashback);
    }

    public function getCashbackLevel($level)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('level', $level))
        ;

        return $this->cashbacks->matching($criteria)->first();
    }
}
