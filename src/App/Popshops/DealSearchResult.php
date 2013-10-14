<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class DealSearchResult implements DomCrawlerInterface
{
    use DealCountTrait;
    use DealsTrait;
    use MerchantsTrait;

    protected $keywords;
    protected $limit;
    protected $offset;
    protected $networks;

    public function __construct(Crawler $node = null, EntityManager $em = null)
    {
        $this->deals = new DealCollection();
        $this->dealTypes = new DealTypeCollection();
        $this->merchants = new MerchantCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->networks = new ArrayCollection();
        $this->em = $em;

        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
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

    public function getNetworks()
    {
        return $this->networks;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $result = $this;
        $result->setLimit($node->filter('search_results')->attr('deal_limit'));
        $result->setOffset($node->filter('search_results')->attr('deal_offset'));
        $result->getDeals()->setTotalCount($node->filter('deals')->attr('total_count'));

        $node->filter('deal_types deal_type')->each(function (Crawler $node, $i) use ($result) {
            $dealType = new DealType($node);
            $result->getDealTypes()->set($dealType->getId(), $dealType);
        });

        $this->populateMerchantsFromCrawler($node->filter('merchants merchant'));
        $this->populateMerchantTypesFromCrawler($node->filter('merchant_types merchant_type'));

        $node->filter('deals deal')->each(function (Crawler $node, $i) use ($result) {
            $deal = new Deal($node);
            foreach (explode(',', $node->attr('deal_type_ids')) as $dealTypeId) {
                if ($result->getDealTypes()->containsKey($dealTypeId)) {
                    $deal->getDealTypes()->add($result->getDealTypes()->get($dealTypeId));
                }
            }
            if ($result->getMerchants()->containsKey($node->attr('merchant_id'))) {
                $deal->setMerchant($result->getMerchants()->get($node->attr('merchant_id')));
            }
            $result->getDeals()->add($deal);
        });

        return $this;
    }
}
