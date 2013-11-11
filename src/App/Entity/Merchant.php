<?php

namespace App\Entity;

use Popshops\Merchant as BaseMerchant;
use Popshops\MerchantCommissionShareTrait;

class Merchant extends BaseMerchant
{
    use MerchantCommissionShareTrait;

    protected $commissionMax = 0.00;

    public function getCommissionMax()
    {
        return $this->commissionMax;
    }

    public function setCommissionMax($value)
    {
        $this->commissionMax = (float) $value;

        return $this;
    }
}
