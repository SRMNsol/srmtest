<?php

namespace App;

use Silex\Application as SilexApplication;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Application\MonologTrait;
use Silex\Application\FormTrait;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Igorw\Silex\ConfigServiceProvider;
use Popshops\Silex\PopshopsServiceProvider;
use Popshops\Silex\PopshopsExtraServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Silex\Provider\DoctrineOrmManagerRegistryProvider;

class Application extends SilexApplication
{
    use TwigTrait;
    use UrlGeneratorTrait;
    use MonologTrait;
    use FormTrait;

    public static function registerBaseServices(Application $app)
    {
        $app->register(new OrmProvider());
        $app->register(new PopshopsServiceProvider());
        $app->register(new CacheProvider());
        $app->register(new MailerProvider());
    }

    public static function registerWebServices(Application $app)
    {
        $app->register(new TemplatingProvider());
        $app->register(new SessionServiceProvider());
        $app->register(new MonologServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        $app->register(new DoctrineOrmManagerRegistryProvider());
        $app->register(new TranslationServiceProvider());
        $app->register(new ServiceControllerServiceProvider());
    }

    public static function registerReportingServices(Application $app)
    {
        $app->register(new PopshopsExtraServiceProvider());
    }

    public static function loadConfig(Application $app, $dir, $params)
    {
        $app->register(new ConfigServiceProvider($dir . '/global.yml', $params));
        if (file_exists($dir . '/local.yml')) {
            $app->register(new ConfigServiceProvider($dir . '/local.yml', $params));
        }
    }
}
