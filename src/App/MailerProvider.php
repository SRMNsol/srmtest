<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\SwiftmailerServiceProvider;
use Swift_Transport_NullTransport as NullTransport;
use Swift_FileSpool as FileSpool;

class MailerProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new SwiftmailerServiceProvider());

        $app['swiftmailer.transport'] = $app->extend('swiftmailer.transport', function ($transport) use ($app) {
            if ($app['debug']) {
                return new NullTransport($app['swiftmailer.transport.eventdispatcher']);
            }

            return $transport;
        });
    }

    public function boot(SilexApp $app)
    {
    }
}
