<?php

namespace App\Popshops;

trait DealsTrait
{
    protected $deals;
    protected $dealTypes;

    public function getDeals()
    {
        return $this->deals;
    }

    public function setDeals(DealCollection $deals = null)
    {
        $this->deals = $deals;

        return $this;
    }

    public function getDealTypes()
    {
        return $this->dealTypes;
    }

    public function setDealTypes(DealTypeCollection $dealTypes = null)
    {
        $this->dealTypes = $dealTypes;

        return $this;
    }
}
