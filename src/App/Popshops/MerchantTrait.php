<?php

namespace App\Popshops;

trait MerchantTrait
{
    protected $merchant;

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }
}
