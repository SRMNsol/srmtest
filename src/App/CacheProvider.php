<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;

use Zend\Cache\Storage\Adapter\Filesystem as FilesystemCache;

class CacheProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app['cache.filesystem'] = $app->share(function () use ($app) {
            $storage = new FilesystemCache([
                'cacheDir' => $app['cache_dir'],
                'dirPermission' => 0777,
                'filePermission' => 0666,
            ]);

            return $storage;
        });

        // default cache storage uses doctrine result cache implementation
        $app['cache.create_storage'] = $app->protect(function () use ($app) {
            $storage = $app['orm.cache.locator']('default', 'result', $app['orm.em.options']);

            return $storage;
        });

        // popshops cache uses default cache storage
        $app['popshops.cache_storage'] = $app->share(function () use ($app) {
            return $app['cache.create_storage']();
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
