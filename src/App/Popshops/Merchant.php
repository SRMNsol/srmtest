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
    protected $description;
    protected $cashbackRate = 0.00;
    protected $cashbackType = self::CASHBACK_TYPE_FIXED;

    const CASHBACK_TYPE_FIXED = 'fixed';
    const CASHBACK_TYPE_PERCENTAGE = 'percentage';

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($text)
    {
        $this->description = $text;

        return $this;
    }

    public function getCashbackRate()
    {
        return $this->cashbackRate;
    }

    public function setCashbackRate($value)
    {
        $this->cashbackRate = (float) $value;

        return $this;
    }

    public function getCashbackType()
    {
        return $this->cashbackType;
    }

    public function setCashbackType($value)
    {
        $this->cashbackType = $value;

        return $this;
    }

    public function getCashbackRateText($sharePct = 100, $currency = '$')
    {
        $text = number_format($this->cashbackRate * ($sharePct / 100), 2);
        $text = preg_replace('/\.00$/', '', $text);

        switch ($this->cashbackType) {
            case self::CASHBACK_TYPE_FIXED :
                return $currency . $text;
            case self::CASHBACK_TYPE_PERCENTAGE :
                return $text . '%';
        }

        return null;
    }

    public function calculateFinalPrice($price, $sharePct = 100)
    {
        $rate = $this->cashbackRate * ($sharePct / 100);

        switch ($this->cashbackType) {
            case self::CASHBACK_TYPE_FIXED :
                return $price - $rate;
            case self::CASHBACK_TYPE_PERCENTAGE :
                return $price * ($rate / 100);
        }

        return $price;
    }

    public function populateFromCrawler(Crawler $node)
    {
        $this->setId($node->attr('id'));
        $this->setNetworkMerchantId($node->attr('network_id') . '-' . $node->attr('network_merchant_id'));
        $this->setName($node->attr('name'));
        $this->setLogoUrl($node->attr('logo_url'));
        $this->setUrl($node->attr('url'));

        if ($node->attr('product_count')) {
            $this->setProductCount($node->attr('product_count'));
        }

        if ($node->attr('deal_count')) {
            $this->setDealCount($node->attr('deal_count'));
        }

        return $this;
    }
}
