<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class MerchantCollection extends ArrayCollection implements DomCrawlerInterface
{
    use TotalCountTrait;

    protected $catalogKey;

    public function __construct($node = [])
    {
        parent::__construct(is_array($node) ? $node : []);
        if ($node instanceof Crawler) {
            $this->populateFromCrawler($node);
        }
    }

    public function getCatalogKey()
    {
        return $this->catalogKey;
    }

    public function setCatalogKey($catalogKey)
    {
        $this->catalogKey = $catalogKey;

        return $this;
    }

    public function filter(\Closure $p)
    {
        $collection = parent::filter($p);
        $collection->setCatalogKey($this->catalogKey);
        $collection->setTotalCount($collection->count());

        return $collection;
    }

    public function filterByNamePrefix($prefix)
    {
        if (!isset($prefix)) {
            return $this;
        }

        return $this->filter(function (Merchant $merchant) use ($prefix) {
            $pattern = ($prefix === '*') ? '\d' : preg_quote($prefix);
            if (preg_match("/^$pattern/i", $merchant->getName())) {
                return $merchant;
            }
        });
    }

    public function slice($offset, $length = null)
    {
        $collection = new static(parent::slice($offset, $length));
        $collection->setCatalogKey($this->catalogKey);
        $collection->setTotalCount($collection->count());

        return $collection;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $collection = $this;
        $collection->setCatalogKey($node->filter('merchants')->attr('catalog_key'));
        $collection->setTotalCount($node->filter('merchants')->attr('total_count'));

        $node->filter('merchants merchant')->each(function (Crawler $node, $i) use ($collection) {
            $merchant = new Merchant($node);
            $collection->set($merchant->getId(), $merchant);
        });
    }
}
