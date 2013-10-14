<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class MerchantSearchResult
{
    use DealsTrait;
    use MerchantsTrait;

    public function __construct()
    {
        $this->merchants = new MerchantCollection();
        $this->merchantTypes = new ArrayCollection();
    }
}
