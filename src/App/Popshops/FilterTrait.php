<?php

namespace App\Popshops;

trait FilterTrait
{
    protected $itemCount;

    public function getItemCount()
    {
        return $this->itemCount;
    }

    public function setItemCount($count)
    {
        $this->itemCount = $count;

        return $this;
    }
}
