<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Guzzle\Http\Client;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Plugin\Cache\SkipRevalidation;
use Guzzle\Plugin\Cache\DefaultCacheStorage;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Cache\CacheAdapterFactory;
use Guzzle\Log\PsrLogAdapter;
use Guzzle\Log\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Zend\Cache\Storage\Adapter\Filesystem as FilesystemCache;
use App\Reporting\LinkshareReport;
use App\Reporting\CommissionJunctionReport;
use App\Reporting\PepperjamReport;
use App\Reporting\ShareasaleReport;
use App\Reporting\ImpactRadiusReport;
use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\PasswordCredentials;
use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\RefreshToken;

class ReportingServiceProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app['reporting.cache_plugin'] = $app->share(function () use ($app) {
            $storage = $app['cache.default_storage'];

            if ($storage !== null) {
                $options['storage'] = new DefaultCacheStorage(CacheAdapterFactory::fromCache($storage));

                if ($app['debug']) {
                    $options['revalidation'] = new SkipRevalidation();
                }

                return new CachePlugin($options);
            }

            return null;
        });

        $app['reporting.log_plugin'] = $app->share(function () use ($app) {
            $logDir = $app['log_dir'];

            if (file_exists($logDir) && is_dir($logDir)) {
                $log = new Logger('reporting.api-client');
                $level = $app['debug'] ? Logger::DEBUG : Logger::ERROR;
                $logFile = $logDir . '/reporting.' . date('Ymd') . '.log';

                if (!file_exists($logFile)) {
                    touch($logFile);
                    chmod($logFile, 0666);
                }

                $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

                return new LogPlugin(new PsrLogAdapter($log), MessageFormatter::SHORT_FORMAT);
            }
        });

        $app['reporting.debug'] = false;

        $app['reporting.default_plugins'] = $app->share(function () use ($app) {
            return array_filter([
                $app['reporting.cache_plugin'],
                $app['reporting.log_plugin'],
                $app['reporting.debug'] ? LogPlugin::getDebugPlugin() : null,
            ]);
        });

        $app['rakuten_oauth2_url'] = '';

        $app['rakuten_oauth2_config'] = [
            'username' => null,
            'password' => null,
            'client_id' => null,
            'client_secret' => null,
            'scope' => null,
        ];

        $app['rakuten_oauth2_plugin'] = $app->share(function () use ($app) {
            $oauth2Client = new Client($app['rakuten_oauth2_url']);
            $grantType = new PasswordCredentials($oauth2Client, $app['rakuten_oauth2_config']);
            $refreshTokenGrantType = new RefreshToken($oauth2Client, $app['rakuten_oauth2_config']);
            $oauth2Plugin = new Oauth2Plugin($grantType, $refreshTokenGrantType);

            if ($app['reporting.debug']) {
                $oauth2Client->addSubscriber(LogPlugin::getDebugPlugin());
            }

            // get cached token
            $storage = $app['cache.default_storage'];
            $cacheKey = 'rakuten_oauth2_access_token';
            $storedAccessToken = null;

            if ($storage->contains($cacheKey)) {
                $storedAccessToken = $storage->fetch($cacheKey);
                $oauth2Plugin->setAccessToken($storedAccessToken);
            }

            $accessToken = $oauth2Plugin->getAccessToken();

            if ($storedAccessToken !== $accessToken) {
                $storage->save($cacheKey, $accessToken, $ttl = $accessToken['expires'] - time());
            }

            return $oauth2Plugin;
        });

        $app['linkshare_security_token'] = null;

        $app['linkshare_report'] = $app->share(function () use ($app) {
            $plugins = $app['reporting.default_plugins'];

            // add oauth2 plugin for rakuten
            $plugins[] = $app['rakuten_oauth2_plugin'];

            return LinkshareReport::create($app['linkshare_security_token'], $app['orm.em'], $plugins);
        });

        $app['cj_developer_key'] = null;

        $app['cj_report'] = $app->share(function () use ($app) {
            return CommissionJunctionReport::create(
                $app['cj_developer_key'],
                $app['orm.em'],
                $app['reporting.default_plugins']
            );
        });

        $app['pepperjam_publisher_api_key'] = null;

        $app['pepperjam_report'] = $app->share(function () use ($app) {
            return PepperjamReport::create(
                $app['pepperjam_publisher_api_key'],
                $app['orm.em'],
                $app['reporting.default_plugins']
            );
        });

        $app['shareasale_affiliate_id'] = null;
        $app['shareasale_token'] = null;
        $app['shareasale_api_secret'] = null;

        $app['shareasale_report'] = $app->share(function () use ($app) {
            return ShareasaleReport::create(
                $app['shareasale_affiliate_id'],
                $app['shareasale_token'],
                $app['shareasale_api_secret'],
                $app['orm.em'],
                $app['reporting.default_plugins']
            );
        });

        $app['impactradius_account_sid'] = null;
        $app['impactradius_auth_token'] = null;

        $app['impactradius_report'] = $app->share(function () use ($app) {
            return ImpactRadiusReport::create(
                $app['impactradius_account_sid'],
                $app['impactradius_auth_token'],
                $app['orm.em'],
                $app['reporting.default_plugins']
            );
        });
    }

    public function boot(SilexApp $app)
    {

    }
}
