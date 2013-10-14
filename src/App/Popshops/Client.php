<?php

namespace App\Popshops;

use Guzzle\Http\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class Client
{
    protected $client;
    protected $em;

    public function __construct(HttpClient $client, EntityManager $em = null)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function setEntityManager(EntityManager $em = null)
    {
        $this->em = $em;

        return $this;
    }

    public static function create($publicKey, EntityManager $em, array $plugins = [])
    {
        $client = new HttpClient('http://api.popshops.com/v2/{publicKey}', ['publicKey' => $publicKey]);

        foreach ($plugins as $plugin) {
            $client->addSubscriber($plugin);
        }

        return new self($client, $em);
    }

    protected function request($path)
    {
        $response = $this->client->get($path)->send();

        return new Crawler($response->getBody(true));
    }

    public function parallelRequests(array $paths)
    {
        $requests = [];
        foreach ($paths as $path) {
            $requests[] = $this->client->get($path);
        }
        $responses = $this->client->send($requests);
        $return = [];
        foreach ($responses as $response) {
            $return[] = new Crawler($response->getBody(true));
        }

        return $return;
    }

    public function getMerchants($catalogKey = null)
    {
        $crawler = $this->request(['merchants.xml{?catalog_key}', [
            'catalog_key' => $catalogKey,
        ]]);

        return new MerchantSearchResult($crawler, $this->em);
    }

    public function findProducts($catalogKey, $keywords = null, array $params = [])
    {
        $params = [
            'catalog_key' => $catalogKey,
            'keywords' => $keywords,
        ] + $params + [
            'include_product_ids' => 1,
            'include_product_groups' => 1,
            'product_limit' => 25,
            'product_offset' => 0,
        ];

        $crawler = $this->request(['products.xml{?' . implode(',', array_keys($params)) . '}', $params]);

        return new ProductSearchResult($crawler, $this->em);
    }

    public function getDealTypes()
    {
        $crawler = $this->request('deal_types.xml');

        return new DealTypeCollection($crawler);
    }

    public function findDeals($catalogKey, array $params = [])
    {
        $params = [
            'catalog_key' => $catalogKey,
        ] + $params + [
            'include_deal_ids' => 1,
            'deal_limit' => 25,
            'deal_offset' => 0,
        ];

        $crawler = $this->request(['deals.xml{?' . implode(',', array_keys($params))  . '}', $params]);

        return new DealSearchResult($crawler, $this->em);
    }

    public function findMerchants($catalogKey, array $params = [])
    {
        $merchantParams = ['catalog_key' => $catalogKey] + $params;
        $dealParams = ['catalog_key' => $catalogKey, 'include_deal_ids' => 1] + $params;

        $crawlers = $this->parallelRequests([
            ['merchants.xml{?' . implode(',', array_keys($merchantParams)) . '}', $merchantParams],
            ['deals.xml{?' . implode(',', array_keys($dealParams)) . '}', $dealParams],
            ['products.xml{?catalog_key}', ['catalog_key' => $catalogKey]],
        ]);

        $merchantResult = new MerchantSearchResult($crawlers[0], $this->em);
        $dealResult = new DealSearchResult($crawlers[1], $this->em);
        $productResult = new ProductSearchResult($crawlers[2], $this->em);

        $merchantResult->setMerchantTypes($productResult->getMerchantTypes());
        $merchantResult->setDeals($dealResult->getDeals());
        $merchantResult->setDealTypes($dealResult->getDealTypes());

        return $merchantResult;
    }
}
