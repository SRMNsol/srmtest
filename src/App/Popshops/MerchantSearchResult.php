<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class MerchantSearchResult implements DomCrawlerInterface
{
    use DealsTrait;
    use MerchantsTrait;

    public function __construct(Crawler $node = null, EntityManager $em = null)
    {
        $this->merchants = new MerchantCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->em = $em;

        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->merchants->setCatalogKey($node->filter('merchants')->attr('catalog_key'));
        $this->merchants->setTotalCount($node->filter('merchants')->attr('total_count'));

        $this->populateMerchantsFromCrawler($node->filter('merchants merchant'));
        $this->populateMerchantTypesFromCrawler($node->filter('merchant_types merchant_type'));
    }

}
