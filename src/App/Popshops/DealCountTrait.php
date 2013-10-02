<?php

namespace App\Popshops;

trait DealCountTrait
{
    protected $dealCount;

    public function getDealCount()
    {
        return $this->dealCount;
    }

    public function setDealCount($count)
    {
        $this->dealCount = $count;

        return $this;
    }
}
