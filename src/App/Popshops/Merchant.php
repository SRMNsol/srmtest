<?php

namespace App\Popshops;

class Merchant
{
    protected $id;
    protected $name;
    protected $logoUrl;
    protected $url;
    protected $productCount;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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

    public function getProductCount()
    {
        return $this->productCount;
    }

    public function setProductCount($count)
    {
        $this->productCount = $count;

        return $this;
    }
}
