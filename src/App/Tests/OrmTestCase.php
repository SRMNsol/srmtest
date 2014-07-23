<?php

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Popshops\Test\OrmTestCase as BaseOrmTestCase;
use App\Application;
use App\OrmProvider;
use App\Entity\User;

class OrmTestCase extends BaseOrmTestCase
{
    public function setUpOrm()
    {
        $app = new Application();
        $app->register(new OrmProvider());
        Application::loadConfig($app, __DIR__ . '/../../../config', [
            'root_dir' => realpath(__DIR__ . '/../../..'),
        ]);

        // create in memory sqlite
        $app['db.options'] = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $this->em = $app['orm.em'];
        $this->schemaTool = new SchemaTool($this->em);
        $this->loader = new Loader();
        $this->executor = new ORMExecutor($this->em, new ORMPurger());
    }

    public function setUp()
    {
        $this->setUpOrm();
        $this->createFullSchema();
    }

    protected function createUserEntity($i)
    {
        $user = new User();
        $user->setEmail("$i@example.com");
        $user->setPaymentMethod('x');
        $user->setPaypalEmail("$i@example.com");
        $user->setAlias("user$i");
        $user->setLastLoginAt(new \DateTime());
        $user->setLastReferAt(new \DateTime());
        $user->setCreatedAt(new \DateTime());
        $user->setFacebookAccessToken("test");
        $user->setTwitterTokenSecret("test");
        $user->setTwitterAccessToken("test");
        $user->setPassword("Pa55w0rd");
        $user->setLastCashbackAt(new \DateTime());

        return $user;
    }
}
