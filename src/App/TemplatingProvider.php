<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

use SilexAssetic\AsseticServiceProvider;
use Assetic\Filter\Yui\CssCompressorFilter;
use Assetic\Filter\Yui\JsCompressorFilter;
use Assetic\Asset\AssetCache;
use Assetic\Asset\GlobAsset;
use Assetic\Cache\FilesystemCache;

class TemplatingProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => $app['template_path']
        ));

        $app->register(new UrlGeneratorServiceProvider());

        $app->register(new AsseticServiceProvider());

        $app['assetic.path_to_web'] = __DIR__ . '/assets';
        $app['assetic.options'] = array(
            'debug' => true,
        );
        $app['assetic.filter_manager'] = $app->share(
            $app->extend('assetic.filter_manager', function($fm, $app) {
                $fm->set('yui_css', new CssCompressorFilter(
                    '/usr/share/yui-compressor/yui-compressor.jar'
                ));
                $fm->set('yui_js', new JsCompressorFilter(
                    '/usr/share/yui-compressor/yui-compressor.jar'
                ));

                return $fm;
            })
        );
        $app['assetic.asset_manager'] = $app->share(
            $app->extend('assetic.asset_manager', function($am, $app) {
                $am->set('styles', new AssetCache(
                    new GlobAsset(
                        __DIR__ . '/resources/css/*.css',
                        array($app['assetic.filter_manager']->get('yui_css'))
                    ),
                    new FilesystemCache(__DIR__ . '/cache/assetic')
                ));
                $am->get('styles')->setTargetPath('css/styles.css');

                return $am;
            })
        );

    }

    public function boot(SilexApp $app)
    {

    }
}
