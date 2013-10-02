<?php

namespace App\Popshops;

trait ProductCountTrait
{
    protected $productCount = 0;

    public function getProductCount()
    {
        return $this->productCount;
    }

    public function setProductCount($count)
    {
        $this->productCount = (int) $count;

        return $this;
    }
}
