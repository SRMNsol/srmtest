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
            $storage = new FilesystemCache(array(
                'cacheDir' => $app['cache_path'],
            ));

            return $storage;
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
