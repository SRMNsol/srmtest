<?php

namespace App\Controller;

use Twig_Environment as Twig;

trait TwigTrait
{
    protected $twig;

    public function setTwig(Twig $twig)
    {
        $this->twig = $twig;

        return $this;
    }

    public function render($template, $params = [])
    {
        return $this->twig->render($template, $params);
    }
}
