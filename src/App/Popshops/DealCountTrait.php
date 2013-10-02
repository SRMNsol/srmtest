<?php

namespace App\Popshops;

trait DealCountTrait
{
    protected $dealCount = 0;

    public function getDealCount()
    {
        return $this->dealCount;
    }

    public function setDealCount($count)
    {
        $this->dealCount = (int) $count;

        return $this;
    }
}
