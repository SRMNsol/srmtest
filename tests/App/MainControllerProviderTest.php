<?php

use App\Tests\WebTestCase;
use App\MainControllerProvider;

class MainControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = parent::createApplication();
        $app->mount('/', new MainControllerProvider());

        return $app;
    }

    public function testLoadingDashboardIsOk()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }
}
