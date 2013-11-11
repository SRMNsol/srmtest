<?php

namespace App\Entity;

use Popshops\Product as BaseProduct;
use Popshops\ProductCommissionShareTrait;

class Product extends BaseProduct
{
    use ProductCommissionShareTrait;
}
