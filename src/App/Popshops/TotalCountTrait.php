<?php

namespace App\Popshops;

trait TotalCountTrait
{
    protected $totalCount = 0;

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function setTotalCount($count)
    {
        $this->totalCount = (int) $count;

        return $this;
    }
}
