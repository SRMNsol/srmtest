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
    protected $commission = 0.00;
    protected $commissionType = self::COMMISSION_TYPE_FIXED;

    const COMMISSION_TYPE_FIXED = 'fixed';
    const COMMISSION_TYPE_PERCENTAGE = 'percentage';

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

    public function getCommission()
    {
        return $this->commission;
    }

    public function setCommission($value)
    {
        $this->commission = (float) $value;

        return $this;
    }

    public function getCommissionType()
    {
        return $this->commissionType;
    }

    public function setCommissionType($value)
    {
        $this->commissionType = $value;

        return $this;
    }

    public function getCashbackPercentage($sharePct = 100)
    {
        if ($this->commissionType === self::COMMISSION_TYPE_PERCENTAGE) {
            return $this->commissionType * ($sharePct / 100);
        }

        return 0;
    }

    public function getCashbackFixed($sharePct = 100)
    {
        if ($this->commissionType === self::COMMISSION_TYPE_FIXED) {
            return $this->commissionType * ($sharePct / 100);
        }

        return 0;
    }

    public function getCashbackText($sharePct = 100, $currency = '$')
    {
        $text = number_format($this->commission * ($sharePct / 100), 2);

        if ($text === '0.00') {
            return null;
        }

        switch ($this->commissionType) {
            case self::COMMISSION_TYPE_FIXED :
                $text = preg_replace('/\.00$/', '', $text);
                return $currency . $text;
            case self::COMMISSION_TYPE_PERCENTAGE :
                $text = preg_replace('/0+$/', '', $text);
                $text = preg_replace('/\.$/', '', $text);
                return $text . '%';
        }

        return null;
    }

    public function calculateCashbackAmount($price, $sharePct = 100)
    {
        $cashback = $this->commission * ($sharePct / 100);
        $amount = 0;

        switch ($this->commissionType) {
            case self::COMMISSION_TYPE_FIXED :
                $amount = $cashback;
                break;
            case self::COMMISSION_TYPE_PERCENTAGE :
                $amount = $price * ($cashback / 100);
                break;
        }

        return $amount;
    }

    public function calculateFinalPrice($price, $sharePct = 100)
    {
        return $price - $this->calculateCashbackAmount($price, $sharePct);
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
