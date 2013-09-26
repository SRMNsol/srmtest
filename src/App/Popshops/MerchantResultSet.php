<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class MerchantResultSet
{
    protected $merchants;
    protected $catalogKey;
    protected $totalCount = 0;

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

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function setTotalCount($count)
    {
        $this->totalCount = $count;

        return $this;
    }
}
