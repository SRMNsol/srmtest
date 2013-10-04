<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;

class PriceRange implements DomCrawlerInterface
{
    use ProductCountTrait;

    protected $minPrice;
    protected $maxPrice;

    public function __construct(Crawler $node = null)
    {
        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function getMinPrice()
    {
        return $this->minPrice;
    }

    public function setMinPrice($price)
    {
        $this->minPrice = $price;

        return $this;
    }

    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    public function setMaxPrice($price)
    {
        $this->maxPrice = $price;

        return $this;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setMinPrice($node->attr('min'));
        $this->setMaxPrice($node->attr('max'));
        $this->setProductCount($node->attr('product_count'));

        return $this;
    }
}
