<?php

use App\Tests\WebTestCase;
use App\Controller\DashboardControllerProvider;

class DashboardControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = parent::createApplication();
        $app->mount('/', new DashboardControllerProvider());

        return $app;
    }

    public function testDashboardPageResponseIsOk()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }
}
