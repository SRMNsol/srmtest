<?php

namespace App\Popshops;

class Deal
{
    use ItemCountTrait;

    protected $name;
    protected $dealType;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDealType()
    {
        return $this->dealType;
    }

    public function setDealType(DealType $type)
    {
        $this->dealType = $type;

        return $this;
    }
}
