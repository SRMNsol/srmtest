<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

class OrmProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new DoctrineServiceProvider());
        $app->register(new DoctrineOrmServiceProvider());

        // handle enum
        $app['db'] = $app->share($app->extend('db', function ($db, $app) {
            $db->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            return $db;
        }));
    }

    public function boot(SilexApp $app)
    {
    }
}
