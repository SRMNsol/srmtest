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

        return new MerchantCollection($crawler);
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

        return new ProductSearchResult($crawler);
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
            'deal_limit' => 25,
            'deal_offset' => 0,
        ];

        $crawler = $this->request(['deals.xml{?' . implode(',', array_keys($params))  . '}', $params]);

        return new DealSearchResult($crawler);
    }

    public function findMerchants($catalogKey, array $params = [])
    {
        $params = [
            'catalog_key' => $catalogKey,
        ] + $params;

        $crawlers = $this->parallelRequests([
            ['merchants.xml{?' . implode(',', array_keys($params)) . '}', $params],
            ['deals.xml{?' . implode(',', array_keys($params)) . '}', $params],
            ['products.xml{?catalog_key}', ['catalog_key' => $catalogKey]],
        ]);

        $merchants = new MerchantCollection($crawlers[0]);
        $dealResult = new DealSearchResult($crawlers[1]);
        $dealResult->getMerchants()->forAll(function ($id, $relMerchant) use ($merchants) {
            if ($merchants->containsKey($relMerchant->getId())) {
                $merchants[$relMerchant->getId()]->setDealCount($relMerchant->getDealCount());
            }
            return true;
        });
        $productResult = new ProductSearchResult($crawlers[2]);

        $result = new MerchantSearchResult();
        $result->setMerchants($merchants);
        $result->setMerchantTypes($productResult->getMerchantTypes());
        $result->setDeals($dealResult->getDeals());
        $result->setDealTypes($dealResult->getDealTypes());

        return $result;
    }
}
