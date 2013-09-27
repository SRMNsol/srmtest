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

        $attrs = $crawler->filter('merchants')->extract(['catalog_key', 'total_count']);
        $result->setCatalogKey($attrs[0][0]);
        $result->setItemCount($attrs[0][1]);

        foreach ($crawler->filter('merchant') as $node) {
            $merchant = new Merchant();
            $merchant->setId($node->getAttribute('id'));
            $merchant->setName($node->getAttribute('name'));
            $merchant->setLogoUrl($node->getAttribute('logo_url'));
            $merchant->setUrl($node->getAttribute('url'));
            $merchant->setItemCount($node->getAttribute('product_count'));

            $result->getMerchants()->add($merchant);
        }

        return $result;
    }

    public function findProducts($catalogKey, $keywords)
    {
        $crawler = $this->request(['products.xml{?catalog_key,keywords}', ['catalog_key' => $catalogKey, 'keywords' => $keywords]]);

        $result = new ProductResultSet();

        $attrs = $crawler->filter('search_results')->extract(['keywords', 'product_limit', 'product_offset']);
        $result->setLimit($attrs[0][1]);
        $result->setOffset($attrs[0][2]);

        foreach ($crawler->filter('product') as $node) {
            $product = new Product();
            $product->setUrl($node->getAttribute('url'));
            $product->setName($node->getAttribute('name'));
            $product->setDescription($node->getAttribute('description'));
            $product->setLargeImageUrl($node->getAttribute('large_image_url'));
            $product->setMerchantPrice($node->getAttribute('merchant_price'));
            $product->setRetailPrice($node->getAttribute('retail_price'));

            $result->getProducts()->add($product);
        }

        return $result;
    }
}
