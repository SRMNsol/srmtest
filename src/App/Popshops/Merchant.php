<?php

namespace App\Popshops;

use Symfony\Component\DomCrawler\Crawler;

class Merchant implements DomCrawlerInterface
{
    use ProductCountTrait;
    use DealCountTrait;

    protected $id;
    protected $networkMerchantId;
    protected $merchantType;
    protected $name;
    protected $logoUrl;
    protected $url;

    public function __construct(Crawler $node = null)
    {
        if (isset($node)) {
            $this->populateFromCrawler($node);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getNetworkMerchantId()
    {
        return $this->networkMerchantId;
    }

    public function setNetworkMerchantId($id)
    {
        $this->networkMerchantId = $id;

        return $this;
    }

    public function getMerchantType()
    {
        return $this->merchantType;
    }

    public function setMerchantType(MerchantType $type)
    {
        $this->merchantType = $type;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    public function setLogoUrl($url)
    {
        $this->logoUrl = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setId($node->attr('id'));
        $this->setNetworkMerchantId($node->attr('network_id') . '-' . $node->attr('network_merchant_id'));
        $this->setName($node->attr('name'));
        $this->setLogoUrl($node->attr('logo_url'));
        $this->setUrl($node->attr('url'));
        $this->setProductCount($node->attr('product_count'));
        $this->setDealCount($node->attr('deal_count'));

        return $this;
    }
}
