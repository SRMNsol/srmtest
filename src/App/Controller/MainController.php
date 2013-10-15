<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController implements TwigInterface
{
    use TwigTrait;

    public function dashboard()
    {
        return new Response($this->render('dashboard.html.twig'));
    }
}
