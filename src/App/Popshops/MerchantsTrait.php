<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

trait MerchantsTrait
{
    protected $merchants;
    protected $merchantTypes;

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

    public function populateMerchantsFromCrawler(Crawler $nodes)
    {
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $id = $node->attr('id');

            if (isset($this->merchants[$id])) {
                $merchant = $this->merchant[$id];
                $merchant->populateFromCrawler($node);
            } else {
                $merchant = new Merchant($node);
                $this->merchants[$id] = $merchant;
            }
        }
    }

    public function populateMerchantTypesFromCrawler(Crawler $nodes)
    {
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $id = $node->attr('id');

            if (isset($this->merchantTypes[$id])) {
                $merchantType = $this->merchantType[$id];
                $merchantType->populateFromCrawler($node);
            } else {
                $merchantType = new MerchantType($node);
                $this->merchantTypes[$id] = $merchantType;
            }
        }
    }
}
