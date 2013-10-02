<?php

namespace App\Popshops;

trait ProductCountTrait
{
    protected $productCount;

    public function getProductCount()
    {
        return $this->productCount;
    }

    public function setProductCount($count)
    {
        $this->productCount = $count;

        return $this;
    }
}
