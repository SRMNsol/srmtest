<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class MerchantCollection extends ArrayCollection
{
    use TotalCountTrait;

    protected $catalogKey;

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
