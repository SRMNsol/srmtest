<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Guzzle\Http\Client as HttpClient;
use Guzzle\Cache\DoctrineCacheAdapter;
use Doctrine\Common\Cache\FilesystemCache;
use Aws\Common\Aws;
use App\Assets\LogoManager;
use App\Assets\LogoEventSubscriber;

class AwsProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app['aws.config'] = [];
        $app['bucket_dir'] = null;
        $app['bucket_url'] = null;

        $app['aws'] = $app->share(function () use ($app) {
            $config = $app['aws.config'];
            $cacheAdapter = new DoctrineCacheAdapter(new FilesystemCache($app['cache_dir']));
            $config['credentials.cache'] = $cacheAdapter;
            $aws = Aws::factory($config);
            return $aws;
        });

        $app['aws.s3'] = $app->share(function () use ($app) {
            $client = $app['aws']->get('s3');
            return $client;
        });

        $app['orm.em'] = $app->share(
            $app->extend('orm.em', function ($em) use ($app) {
                $em->getEventManager()->addEventSubscriber(
                    new LogoEventSubscriber(
                        $app['temp_dir'],
                        $app['bucket_dir'],
                        $app['bucket_url']
                    )
                );
                return $em;
            })
        );

        $app['logo_manager'] = $app->share(function () use ($app) {
            $lm = new LogoManager($app['orm.em'], $app['validator']);
            return $lm;
        });
    }

    public function boot(SilexApp $app)
    {
        $app['aws.s3']->registerStreamWrapper();
    }
}
