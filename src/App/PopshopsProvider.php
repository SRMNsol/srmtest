<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;

use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\SkipRevalidation;
use Guzzle\Plugin\Cache\DefaultCacheStorage;
use Guzzle\Cache\CacheAdapterFactory;

use App\Popshops\Client as PopshopsClient;

class PopshopsProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app['popshops.cache_plugin'] = $app->share(function () use ($app) {
            if (isset($app['cache.filesystem'])) {
                return new CachePlugin([
                    'storage' => new DefaultCacheStorage(CacheAdapterFactory::fromCache($app['cache.filesystem'])),
                    'revalidation' => new SkipRevalidation(),
                ]);
            }
        });

        $app['popshops.client'] = $app->share(function () use ($app) {
            $plugins = array_filter([
                $app['popshops.cache_plugin']
            ]);

            return PopshopsClient::create($app['popshops.public_key'], $plugins);
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
