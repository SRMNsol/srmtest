<?php

use App\Tests\WebTestCase;
use App\ControllerProvider;

class ControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = parent::createApplication();
        $app->mount('/', new ControllerProvider());

        return $app;
    }

}
