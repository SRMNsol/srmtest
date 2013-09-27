<?php

namespace App\Popshops;

class PriceRange
{
    use ItemCountTrait;

    protected $minPrice;
    protected $maxPrice;

    public function getMinPrice()
    {
        return $this->minPrice;
    }

    public function setMinPrice($price)
    {
        $this->minPrice = $price;

        return $this;
    }

    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    public function setMaxPrice($price)
    {
        $this->maxPrice = $price;

        return $this;
    }
}
