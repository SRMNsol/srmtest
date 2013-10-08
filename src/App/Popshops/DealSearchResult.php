<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class DealSearchResult
{
    use DealCountTrait;
    use DealsTrait;

    protected $keywords;
    protected $limit;
    protected $offset;
    protected $merchants;
    protected $merchantTypes;
    protected $networks;

    public function __construct(Crawler $node = null)
    {
        $this->deals = new DealCollection();
        $this->dealTypes = new ArrayCollection();
        $this->merchants = new ArrayCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->networks = new ArrayCollection();

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

        $node->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant($node);
            $result->getMerchants()->set($merchant->getId(), $merchant);
        });

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

        $node->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType($node);
            $result->getMerchantTypes()->set($merchantType->getId(), $merchantType);
        });

        return $this;
    }
}
