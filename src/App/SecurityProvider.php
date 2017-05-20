<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\SecurityServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;

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
                    'form'    => [
                        'login_path' => '/login', 
                        'check_path' => '/login_check',
                        'refcheck' => '/refcheck'
                        ],
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
