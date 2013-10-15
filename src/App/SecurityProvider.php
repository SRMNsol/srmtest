<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\SecurityServiceProvider;

class SecurityProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new SecurityServiceProvider(), [
            'security.firewalls' => [
                'login' => [
                    'pattern' => '/login$',
                ],
                'admin' => [
                    'pattern' => '^.*$',
                    'form'    => ['login_path' => '/login', 'check_path' => '/login_check'],
                    'logout'  => ['logout_path' => '/logout'],
                    'users'   => $app['user.provider'],
                ],
            ],
            'security.access_rules' => [
                ['^.*$', 'ROLE_ADMIN'],
            ],
        ]);
    }

    public function boot(SilexApp $app)
    {
    }
}
