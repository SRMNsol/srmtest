<?php

namespace App\Popshops;

trait TotalCountTrait
{
    protected $totalCount;

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function setTotalCount($count)
    {
        $this->totalCount = $count;

        return $this;
    }
}
