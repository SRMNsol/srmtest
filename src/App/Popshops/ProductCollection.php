<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class ProductCollection extends ArrayCollection
{
    use TotalCountTrait;
}
