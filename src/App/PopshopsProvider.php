<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;

use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\SkipRevalidation;
use Guzzle\Plugin\Cache\DefaultCacheStorage;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Cache\CacheAdapterFactory;
use Guzzle\Log\PsrLogAdapter;
use Guzzle\Log\MessageFormatter;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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

        $app['popshops.log_plugin'] = $app->share(function () use ($app) {
            $log = new Logger('apilog');
            $level = $app['debug'] ? Logger::DEBUG : Logger::ERROR;
            $log->pushHandler(new StreamHandler($app['log_dir'] . '/popshops.log', Logger::DEBUG));

            return new LogPlugin(new PsrLogAdapter($log), MessageFormatter::SHORT_FORMAT);
        });

        $app['popshops.client'] = $app->share(function () use ($app) {
            $plugins = array_filter([
                $app['popshops.cache_plugin'],
                $app['popshops.log_plugin']
            ]);

            return PopshopsClient::create($app['popshops.public_key'], $plugins);
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
