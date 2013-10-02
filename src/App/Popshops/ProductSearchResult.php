<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class ProductSearchResult
{
    protected $keywords;
    protected $limit;
    protected $offset;
    protected $products;
    protected $priceRanges;
    protected $merchants;
    protected $merchantTypes;
    protected $brands;
    protected $suggestedMerchants;
    protected $networks;

    public function __construct()
    {
        $this->products = new ProductCollection();
        $this->priceRanges = new ArrayCollection();
        $this->merchants = new ArrayCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->suggestedMerchants= new ArrayCollection();
        $this->networks = new ArrayCollection();
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
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

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function getSuggestedMerchants()
    {
        return $this->suggestedMerchants;
    }

    public function getNetworks()
    {
        return $this->networks;
    }
}
