<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class MerchantSearchResult
{
    use DealsTrait;

    protected $merchants;
    protected $merchantTypes;

    public function __construct()
    {
        $this->merchants = new MerchantCollection();
        $this->merchantTypes = new ArrayCollection();
    }

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function setMerchants(MerchantCollection $merchants)
    {
        $this->merchants = $merchants;

        return $this;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function setMerchantTypes(ArrayCollection $merchantTypes)
    {
        $this->merchantTypes = $merchantTypes;

        return $this;
    }
}
