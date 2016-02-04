<?php

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use App\Application;
use App\OrmProvider;
use App\Entity\User;
use Silex\Provider\ValidatorServiceProvider;

class OrmTestCase
{
    protected $em;
    protected $schemaTool;
    protected $loader;
    protected $executor;
    protected $validator;

    public function setUpOrm()
    {
        $app = new Application();
        $app->register(new OrmProvider());
        $app->register(new ValidatorServiceProvider());

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

        $this->validator = $app['validator'];
    }

    public function setUp()
    {
        $this->setUpOrm();
        $this->createFullSchema();
    }

    public function createSchema(array $classes)
    {
        $em = $this->em;
        $metadatas = array_map(function ($class) use ($em) {
            return $em->getClassMetadata($class);
        }, $classes);

        $this->schemaTool->createSchema($metadatas);
    }

    public function createFullSchema()
    {
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        $this->schemaTool->createSchema($metadatas);
    }

    protected function createUserEntity($i)
    {
        $user = new User();
        $user->setEmail("user$i@example.com");
        $user->setAlias("user$i");
        $user->setPassword("Pa55w0rd");

        return $user;
    }
}
