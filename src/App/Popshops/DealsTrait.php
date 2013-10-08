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

    public function getDealTypes()
    {
        return $this->dealTypes;
    }
}
