<?php

namespace App\Entity;

use Popshops\Network as BaseNetwork;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Network extends BaseNetwork
{
    public function __toString()
    {
        return $this->name;
    }
}
