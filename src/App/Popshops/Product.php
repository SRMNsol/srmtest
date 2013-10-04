<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;

class Product implements DomCrawlerInterface
{
    use ProductGroupTrait;
    use MerchantTrait;
    use NetworkTrait;

    protected $url;
    protected $name;
    protected $description;
    protected $largeImageUrl;
    protected $merchantPrice = 0.00;
    protected $retailPrice = 0.00;

    public function __construct(Crawler $node = null)
    {
        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

       return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;

        return $this;
    }

    public function getLargeImageUrl()
    {
        return $this->largeImageUrl;
    }

    public function setLargeImageUrl($url)
    {
        $this->largeImageUrl = $url;

        return $this;
    }

    public function getMerchantPrice()
    {
        return $this->merchantPrice;
    }

    public function setMerchantPrice($price)
    {
        $this->merchantPrice = (float) $price;
    }

    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    public function setRetailPrice($price)
    {
        $this->retailPrice = $price;

        return $this;
    }

    public function getLowestPrice()
    {
        return $this->merchantCount > 1 ? $this->minPrice : $this->merchantPrice;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setUrl($node->attr('url'));
        $this->setName($node->attr('name'));
        $this->setDescription($node->attr('description'));
        $this->setLargeImageUrl($node->attr('large_image_url'));
        $this->setMerchantPrice($node->attr('merchant_price'));
        $this->setRetailPrice($node->attr('retail_price'));

        if ($node->attr('product_group_id')) {
            $this->setMerchantCount($node->attr('product_group_merchant_count'));
            $this->setMinPrice($node->attr('product_group_min_price'));
            $this->setMaxPrice($node->attr('product_group_max_price'));
        } else {
            $this->setMerchantCount(1);
        }

        return $this;
    }
}
