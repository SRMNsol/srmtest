<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Guzzle\Cache\Zf2CacheAdapter;
use Zend\Cache\Storage\Adapter\Filesystem as Zf2FilesystemCache;

use App\Popshops\Client as PopshopsClient;

class PopshopsProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app['popshops.client'] = $app->share(function () use ($app) {
            $cacheAdapter = null;
            if (isset($app['cache.filesystem'])) {
                $storage = $app['cache.filesystem'];
                if ($storage instanceof Zf2FilesystemCache) {
                    $cacheAdapter = new Zf2CacheAdapter($storage);
                }
            }

            return PopshopsClient::create($app['popshops.public_key'], $cacheAdapter);
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
