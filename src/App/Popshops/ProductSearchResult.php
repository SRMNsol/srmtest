<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Crawler;

class ProductSearchResult implements DomCrawlerInterface
{
    use DealsTrait;
    use MerchantsTrait;

    protected $keywords;
    protected $limit;
    protected $offset;
    protected $products;
    protected $priceRanges;
    protected $brands;
    protected $suggestedMerchants;
    protected $networks;

    public function __construct(Crawler $node = null)
    {
        $this->products = new ProductCollection();
        $this->priceRanges = new ArrayCollection();
        $this->merchants = new MerchantCollection();
        $this->merchantTypes = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->suggestedMerchants= new ArrayCollection();
        $this->networks = new ArrayCollection();
        $this->deals = new DealCollection();
        $this->dealTypes = new ArrayCollection();

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

    public function getLowestPrice()
    {
        return array_reduce($this->products->map(function ($product) {
            return $product->getMerchantPrice() ?: 0.00;
        })->toArray(), function ($price1, $price2) {
            return isset($price1) && $price1 < $price2 ? $price1 : $price2;
        });
    }

    public function getHighestPrice()
    {
        return array_reduce($this->products->map(function ($product) {
            return $product->getMerchantPrice() ?: 0.00;
        })->toArray(), function ($price1, $price2) {
            return $price1 > $price2 ? $price1 : $price2;
        });
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
            $result->getMerchants()->set($merchant->getId(), $merchant);
        });

        $node->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType($node);
            $result->getMerchantTypes()->set($merchantType->getId(), $merchantType);
        });

        $node->filter('price_ranges price_range')->each(function (Crawler $node, $i) use ($result) {
            $priceRange = new PriceRange($node);
            $result->getPriceRanges()->add($priceRange);
        });

        $node->filter('brands brand')->each(function (Crawler $node, $i) use ($result) {
            $brand = new Brand($node);
            $result->getBrands()->set($brand->getId(), $brand);
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

        $node->filter('products product')->each(function (Crawler $node, $i) use ($result) {
            $product = new Product($node);

            if ($result->getBrands()->containsKey($node->attr('brand_id'))) {
                $product->setBrand($result->getBrands()->get($node->attr('brand_id')));
            }

            if ($result->getMerchants()->containsKey($node->attr('merchant_id'))) {
                $product->setMerchant($result->getMerchants()->get($node->attr('merchant_id')));
            }

            $result->getProducts()->add($product);
        });
    }
}
