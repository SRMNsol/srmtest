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

    public function testIndexIsProtected()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
