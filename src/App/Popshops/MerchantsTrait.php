<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

trait MerchantsTrait
{
    protected $merchants;
    protected $merchantTypes;

    public function getMerchants()
    {
        return $this->merchants;
    }

    public function setMerchants(MerchantCollection $merchants)
    {
        $this->merchants = $merchants;

        return $this;
    }

    public function getMerchantTypes()
    {
        return $this->merchantTypes;
    }

    public function setMerchantTypes(ArrayCollection $merchantTypes)
    {
        $this->merchantTypes = $merchantTypes;

        return $this;
    }
}
