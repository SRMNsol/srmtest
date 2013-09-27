<?php

namespace App\Popshops;

class Product
{
    protected $url;
    protected $name;
    protected $description;
    protected $merchant;
    protected $network;
    protected $largeImageUrl;
    protected $merchantPrice = 0.00;
    protected $retailPrice = 0.00;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;

        return $this;
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }

    public function getNetwork()
    {
        return $this->network;
    }

    public function setNetwork(Network $network)
    {
        $this->network = $network;

        return $this;
    }

    public function getLargeImageUrl()
    {
        return $this->largeImageUrl;
    }

    public function setLargeImageUrl($url)
    {
        $this->largeImageUrl = $url;

        return $this;
    }

    public function getMerchantPrice()
    {
        return $this->merchantPrice;
    }

    public function setMerchantPrice($price)
    {
        $this->merchantPrice = (float) $price;
    }

    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    public function setRetailPrice($price)
    {
        $this->retailPrice = $price;

        return $this;
    }
}
