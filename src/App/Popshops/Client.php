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

    }
}
