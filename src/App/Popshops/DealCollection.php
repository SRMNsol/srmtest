<?php

namespace App\Popshops;

use Doctrine\Common\Collections\ArrayCollection;

class DealCollection extends ArrayCollection
{
    use TotalCountTrait;

    protected $restriction;

    public function getRestriction()
    {
        return $this->restriction;
    }

    public function setRestriction($value)
    {
        $this->restriction = $value;

        return $this;
    }
}
