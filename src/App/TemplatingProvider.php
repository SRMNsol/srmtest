<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

use SilexAssetic\AsseticServiceProvider;
use Assetic\Filter\Yui\CssCompressorFilter;
use Assetic\Filter\Yui\JsCompressorFilter;
use Assetic\Filter\LessphpFilter;
use Assetic\Asset\AssetCache;
use Assetic\Asset\GlobAsset;
use Assetic\Asset\FileAsset;
use Assetic\Cache\FilesystemCache;

class TemplatingProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new TwigServiceProvider(), ['twig.path' => $app['template_dir']]);
        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new AsseticServiceProvider());

        $app['assetic.path_to_web'] = $app['assets_dir'];
        $app['assetic.options'] = ['debug' => $app['debug']];

        $app['assetic.filter_manager'] = $app->share($app->extend('assetic.filter_manager', function($fm, $app) {
            $fm->set('yui_css', new CssCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('yui_js', new JsCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('lessphp', new LessphpFilter());
            return $fm;
        }));

        $app['assetic.asset_manager'] = $app->share($app->extend('assetic.asset_manager', function($am, $app) {
            $fm = $app['assetic.filter_manager'];

            $am->set('styles', new AssetCache(
                new FileAsset($app['twbs.resources_dir'] . '/less/bootstrap.less', [$fm->get('lessphp'), $fm->get('yui_css')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('styles')->setTargetPath('css/styles.min.css');

            $am->set('scripts', new AssetCache(
                new GlobAsset($app['twbs.resources_dir'] . '/js/*.js', $fm->get('yui_js')),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('scripts')->setTargetPath('js/scripts.min.js');

            return $am;
        }));

    }

    public function boot(SilexApp $app)
    {

    }
}
