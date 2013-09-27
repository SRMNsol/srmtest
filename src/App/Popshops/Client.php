<?php

namespace App\Popshops;

use Guzzle\Http\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;

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
        $crawler = $this->request(['merchants.xml{?catalog_key}', ['catalog_key' => $catalogKey]]);

        $result = new MerchantResultSet();

        $result->setCatalogKey($crawler->filter('merchants')->attr('catalog_key'));
        $result->setItemCount($crawler->filter('merchants')->attr('total_count'));

        $crawler->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant();
            $merchant->setId($node->attr('id'));
            $merchant->setName($node->attr('name'));
            $merchant->setLogoUrl($node->attr('logo_url'));
            $merchant->setUrl($node->attr('url'));
            $merchant->setItemCount($node->attr('product_count'));

            $result->getMerchants()->add($merchant);
        });

        return $result;
    }

    public function findProducts($catalogKey, $keywords)
    {
        $crawler = $this->request(['products.xml{?catalog_key,keywords}', ['catalog_key' => $catalogKey, 'keywords' => $keywords]]);

        $result = new ProductResultSet();

        $result->setKeywords($crawler->filter('search_results')->attr('keywords'));
        $result->setLimit($crawler->filter('search_results')->attr('product_limit'));
        $result->setOffset($crawler->filter('search_results')->attr('product_offset'));
        $result->setItemCount($crawler->filter('products')->attr('total_count'));

        $crawler->filter('merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            $merchant = new Merchant();
            $merchant->setId($node->attr('id'));
            $merchant->setNetworkMerchantId($node->attr('network_id') . '-' . $node->attr('network_merchant_id'));
            $merchant->setName($node->attr('name'));
            $merchant->setLogoUrl($node->attr('logo_url'));
            $merchant->setUrl($node->attr('url'));
            $merchant->setItemCount($node->attr('product_count'));

            $result->getMerchants()->set($node->attr('id'), $merchant);
        });

        $crawler->filter('products product')->each(function (Crawler $node, $i) use ($result) {
            $product = new Product();
            $product->setUrl($node->attr('url'));
            $product->setName($node->attr('name'));
            $product->setDescription($node->attr('description'));
            $product->setLargeImageUrl($node->attr('large_image_url'));
            $product->setMerchantPrice($node->attr('merchant_price'));
            $product->setRetailPrice($node->attr('retail_price'));

            if ($result->getMerchants()->containsKey($node->attr('merchant_id'))) {
                $product->setMerchant($result->getMerchants()->get($node->attr('merchant_id')));
            }

            $result->getProducts()->add($product);
        });

        $crawler->filter('price_ranges price_range')->each(function (Crawler $node, $i) use ($result) {
            $priceRange = new PriceRange();
            $priceRange->setMinPrice($node->attr('min'));
            $priceRange->setMaxPrice($node->attr('max'));
            $priceRange->setItemCount($node->attr('product_count'));

            $result->getPriceRanges()->add($priceRange);
        });

        $crawler->filter('brands brand')->each(function (Crawler $node, $i) use ($result) {
            $brand = new Brand();
            $brand->setId($node->attr('id'));
            $brand->setName($node->attr('name'));
            $brand->setItemCount($node->attr('product_count'));

            $result->getBrands()->add($brand);
        });

        $crawler->filter('merchant_types merchant_type')->each(function (Crawler $node, $i) use ($result) {
            $merchantType = new MerchantType();
            $merchantType->setId($node->attr('id'));
            $merchantType->setName($node->attr('name'));
            $merchantType->setItemCount($node->attr('product_count'));

            $result->getMerchantTypes()->add($merchantType);
        });

        $crawler->filter('suggested_merchants merchant')->each(function (Crawler $node, $i) use ($result) {
            if ($result->getMerchants()->containsKey($node->attr('id'))) {
                $result->getSuggestedMerchants()->add($result->getMerchants()->get($node->attr('id')));
            }
        });

        return $result;
    }
}
