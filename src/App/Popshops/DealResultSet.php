<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class DealResultSet
{
    use ItemCountTrait;

    protected $keywords;
    protected $limit;
    protected $offset;
    protected $deals;
    protected $dealTypes;
    protected $merchants;
    protected $merchantTypes;
    protected $networks;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
        $this->dealTypes = new ArrayCollection();
        $this->merchants = new ArrayCollection();
        $this->merchantTypes = new ArrayCollection();
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

    public function getDeals()
    {
        return $this->deals;
    }

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function getNetworks()
    {
        return $this->networks;
    }
}
