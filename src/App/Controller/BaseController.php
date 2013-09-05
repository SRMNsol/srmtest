<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
