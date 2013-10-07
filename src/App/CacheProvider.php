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
    }

    public function boot(SilexApp $app)
    {
    }
}
