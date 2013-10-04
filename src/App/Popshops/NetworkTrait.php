<?php

namespace App\Popshops;

trait NetworkTrait
{
    protected $network;

    public function getNetwork()
    {
        return $this->network;
    }

    public function setNetwork(Network $network)
    {
        $this->network = $network;

        return $this;
    }
}
