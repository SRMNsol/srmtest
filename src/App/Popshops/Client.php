<?php

namespace App\Popshops;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Cache\CacheAdapterInterface;
use Guzzle\Plugin\Cache\CachePlugin;
use Symfony\Component\DomCrawler\Crawler;

class Client
{
    protected $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public static function create($publicKey, CacheAdapterInterface $cacheAdapter = null)
    {
        $client = new HttpClient('http://api.popshops.com/{version}/{publicKey}', array(
            'version' => 'v2',
            'publicKey' => $publicKey,
            'params.cache.override_ttl' => 3600,
            'params.cache.revalidate' => 'skip'
        ));

        if (isset($cacheAdapter)) {
            $client->addSubscriber(new CachePlugin($cacheAdapter));
        }

        return new self($client);
    }

    protected function request($path, array $params = null)
    {
        $response = $this->client->get($path, $params)->send();

        return new Crawler($response->getBody(true));
    }

    public function getMerchants($catalogKey = null)
    {
        $crawler = $this->request('merchants.xml');

        return $crawler->filter('merchant')->each(function (Crawler $node, $i) {
            $merchant = new Merchant();
            $merchant->setId($node->attr('id'));
            $merchant->setName($node->attr('name'));
            $merchant->setLogoUrl($node->attr('logo_url'));
            $merchant->setUrl($node->attr('url'));
            $merchant->setProductCount($node->attr('product_count'));

            return $merchant;
        });
    }
}
