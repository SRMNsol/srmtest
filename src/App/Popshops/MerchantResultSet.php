<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class MerchantResultSet
{
    use ItemCountTrait;

    protected $merchants;
    protected $catalogKey;

    public function __construct()
    {
        $this->merchants = new ArrayCollection();
    }

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function getCatalogKey()
    {
        return $this->catalogKey;
    }

    public function setCatalogKey($catalogKey)
    {
        $this->catalogKey = $catalogKey;

        return $this;
    }
}
