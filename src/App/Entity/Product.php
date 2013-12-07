<?php

namespace App\Entity;

use Popshops\Product as BaseProduct;
use Popshops\ProductCommissionShareTrait;
use Popshops\SubidTrait;

class Product extends BaseProduct
{
    use ProductCommissionShareTrait;
    use SubidTrait;
}
