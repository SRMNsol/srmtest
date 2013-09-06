<?php

namespace App\Console;

use Pimple;
use Symfony\Component\Console\Helper\Helper;

class ContainerHelper extends Helper
{
    protected $container;

    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        if (!isset($this->container[$name])) {
            throw new \Exception("Unexistent key $name");
        }

        return $this->container[$name];
    }

    public function getName()
    {
        return 'container';
    }
}