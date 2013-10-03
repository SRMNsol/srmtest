<?php

namespace App\Popshops;

use Guzzle\Http\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Collections\ArrayCollection;

class Client
{
    protected $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public static function create($publicKey, array $plugins = [])
    {
        $client = new HttpClient('http://api.popshops.com/v2/{publicKey}', ['publicKey' => $publicKey]);

        foreach ($plugins as $plugin) {
            $client->addSubscriber($plugin);
        }

        return new self($client);
    }

    protected function request($path)
    {
        $response = $this->client->get($path)->send();

        return new Crawler($response->getBody(true));
    }

    public function getMerchants($catalogKey = null)
    {
        $crawler = $this->request(['merchants.xml{?catalog_key}', [
            'catalog_key' => $catalogKey,
        ]]);

        $collection = new MerchantCollection();

        $collection->setCatalogKey($crawler->filter('merchants')->attr('catalog_key'));
        $collection->setTotalCount($crawler->filter('merchants')->attr('total_count'));

        $crawler->filter('merchants merchant')->each(function (Crawler $node, $i) use ($collection) {
            $merchant = new Merchant($node);
            $collection->set($merchant->getId(), $merchant);
        });

        return $collection;
    }

    public function findProducts($catalogKey, $keywords)
    {
        $crawler = $this->request(['products.xml{?catalog_key,keywords,include_product_groups}', [
            'catalog_key' => $catalogKey,
            'keywords' => $keywords,
            'include_product_groups' => 1,
        ]]);

        $result = new ProductSearchResult();
        $result->setKeywords($crawler->filter('search_results')->attr('keywords'));
        $result->setLimit($crawler->filter('search_results')->attr('product_limit'));
        $result->setOffset($crawler->filter('search_results')->attr('product_offset'));
        $result->getProducts()->setTotalCount($crawler->filter('products')->attr('total_count'));

        $crawler->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant($node);
            $result->getMerchants()->add($merchant);
        });

        $crawler->filter('products product')->each(function (Crawler $node, $i) use ($result) {
            $product = new Product($node);
            $result->getProducts()->add($product);
        });

        $crawler->filter('price_ranges price_range')->each(function (Crawler $node, $i) use ($result) {
            $priceRange = new PriceRange($node);
            $result->getPriceRanges()->add($priceRange);
        });

        $crawler->filter('brands brand')->each(function (Crawler $node, $i) use ($result) {
            $brand = new Brand($node);
            $result->getBrands()->add($brand);
        });

        $crawler->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType($node);
            $result->getMerchantTypes()->add($merchantType);
        });

        return $result;
    }

    public function getDealTypes()
    {
        $crawler = $this->request('deal_types.xml');

        $collection = new DealTypeCollection();

        $crawler->filter('deal_type')->each(function (Crawler $node, $i) use ($collection) {
            $dealType = new DealType($node);
            $collection->set($dealType->getId(), $dealType);
        });

        return $collection;
    }

    public function findDeals($catalogKey, $dealType = null, $keywords = null)
    {
        $crawler = $this->request(['deals.xml{?catalog_key,deal_type_id,keywords}', [
            'catalog_key' => $catalogKey,
            'deal_type_id' => $dealType instanceof DealType ? $dealType->getId() : null,
            'keywords' => $keywords,
        ]]);

        $result = new DealSearchResult();
        $result->setLimit($crawler->filter('search_results')->attr('deal_limit'));
        $result->setOffset($crawler->filter('search_results')->attr('deal_offset'));
        $result->getDeals()->setTotalCount($crawler->filter('deals')->attr('total_count'));

        $crawler->filter('deal_types deal_type')->each(function (Crawler $node, $i) use ($result) {
            $dealType = new DealType($node);
            $result->getDealTypes()->set($dealType->getId(), $dealType);
        });

        $crawler->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant($node);
            $result->getMerchants()->set($merchant->getId(), $merchant);
        });

        $crawler->filter('deals deal')->each(function (Crawler $node, $i) use ($result) {
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

        $crawler->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType($node);
            $result->getMerchantTypes()->set($merchantType->getId(), $merchantType);
        });

        return $result;
    }

    public function getMerchantsAndDeals($catalogKey)
    {
        $merchants = $this->getMerchants($catalogKey);
        $this->findDeals($catalogKey)->getMerchants()->forAll(function ($id, $relMerchant) use ($merchants) {
            $merchants[$relMerchant->getId()]->setDealCount($relMerchant->getDealCount());
            return true;
        });

        return $merchants;
    }
}
