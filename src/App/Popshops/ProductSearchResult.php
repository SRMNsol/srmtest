<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class ProductSearchResult implements DomCrawlerInterface
{
    protected $keywords;
    protected $limit;
    protected $offset;
    protected $products;
    protected $priceRanges;
    protected $merchants;
    protected $merchantTypes;
    protected $brands;
    protected $suggestedMerchants;
    protected $networks;

    public function __construct(Crawler $node = null)
    {
        $this->products = new ProductCollection();
        $this->priceRanges = new ArrayCollection();
        $this->merchants = new ArrayCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->suggestedMerchants= new ArrayCollection();
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

    public function getProducts()
    {
        return $this->products;
    }

    public function getPriceRanges()
    {
        return $this->priceRanges;
    }

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function getSuggestedMerchants()
    {
        return $this->suggestedMerchants;
    }

    public function getNetworks()
    {
        return $this->networks;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $result = $this;
        $result->setKeywords($node->filter('search_results')->attr('keywords'));
        $result->setLimit($node->filter('search_results')->attr('product_limit'));
        $result->setOffset($node->filter('search_results')->attr('product_offset'));
        $result->getProducts()->setTotalCount($node->filter('products')->attr('total_count'));

        $node->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant($node);
            $result->getMerchants()->add($merchant);
        });

        $node->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType($node);
            $result->getMerchantTypes()->add($merchantType);
        });

        $node->filter('price_ranges price_range')->each(function (Crawler $node, $i) use ($result) {
            $priceRange = new PriceRange($node);
            $result->getPriceRanges()->add($priceRange);
        });

        $node->filter('brands brand')->each(function (Crawler $node, $i) use ($result) {
            $brand = new Brand($node);
            $result->getBrands()->add($brand);
        });

        $node->filter('products product')->each(function (Crawler $node, $i) use ($result) {
            $product = new Product($node);
            $result->getProducts()->add($product);
        });
    }
}
