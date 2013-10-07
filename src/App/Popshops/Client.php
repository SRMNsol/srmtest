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

        return new MerchantCollection($crawler);
    }

    public function findProducts($catalogKey, $keywords)
    {
        $crawler = $this->request(['products.xml{?catalog_key,keywords,include_product_groups}', [
            'catalog_key' => $catalogKey,
            'keywords' => $keywords,
            'include_product_groups' => 1,
        ]]);

        return new ProductSearchResult($crawler);
    }

    public function getDealTypes()
    {
        $crawler = $this->request('deal_types.xml');

        return new DealTypeCollection($crawler);
    }

    public function findDeals($catalogKey, $dealType = null, $keywords = null)
    {
        $crawler = $this->request(['deals.xml{?catalog_key,deal_type_id,keywords}', [
            'catalog_key' => $catalogKey,
            'deal_type_id' => $dealType instanceof DealType ? $dealType->getId() : null,
            'keywords' => $keywords,
        ]]);

        return new DealSearchResult($crawler);
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
