<?php

namespace App\Popshops;

class Merchant
{
    use ItemCountTrait;

    protected $id;
    protected $networkMerchantId;
    protected $merchantType;
    protected $name;
    protected $logoUrl;
    protected $url;

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
}
