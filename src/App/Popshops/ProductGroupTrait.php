<?php

namespace App\Popshops;

trait ProductGroupTrait
{
    protected $merchantCount = 0;
    protected $minPrice = 0.00;
    protected $maxPrice = 0.00;

    public function getMerchantCount()
    {
        return $this->merchantCount;
    }

    public function setMerchantCount($value)
    {
        $this->merchantCount = $value;

        return $this;
    }

    public function getMinPrice()
    {
        return $this->minPrice;
    }

    public function setMinPrice($price)
    {
        $this->minPrice = (float) $price;

        return $this;
    }

    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    public function setMaxPrice($price)
    {
        $this->maxPrice = (float) $price;

        return $this;
    }
}
