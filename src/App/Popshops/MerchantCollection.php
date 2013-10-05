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

    public function filter(\Closure $p)
    {
        $collection = parent::filter($p);
        $collection->setCatalogKey($this->catalogKey);
        $collection->setTotalCount($collection->count());

        return $collection;
    }

    public function filterByNamePrefix($prefix)
    {
        if (!isset($prefix)) {
            return $this;
        }

        return $this->filter(function (Merchant $merchant) use ($prefix) {
            $pattern = ($prefix === '*') ? '\d' : preg_quote($prefix);
            if (preg_match("/^$pattern/i", $merchant->getName())) {
                return $merchant;
            }
        });
    }

    public function slice($offset, $length = null)
    {
        $collection = new static(parent::slice($offset, $length));
        $collection->setCatalogKey($this->catalogKey);
        $collection->setTotalCount($collection->count());

        return $collection;
    }
}
