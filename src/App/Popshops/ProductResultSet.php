<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class ProductResultSet
{
    use ItemCountTrait;

    protected $keywords;
    protected $limit;
    protected $offset;
    protected $products;
    protected $priceRanges;
    protected $merchantTypes;
    protected $brands;
    protected $networks;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->priceRanges = new ArrayCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->networks = new ArrayCollection();
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getPriceRanges()
    {
        return $this->priceRanges;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function getNetworks()
    {
        return $this->networks;
    }
}
