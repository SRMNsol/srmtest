<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;

use App\Controller\BaseController;
use App\Controller\TwigTrait;

class MainController extends BaseController
{
    use TwigTrait;

    public function dashboard()
    {
        return new Response($this->render('dashboard.html.twig'));
    }
}
