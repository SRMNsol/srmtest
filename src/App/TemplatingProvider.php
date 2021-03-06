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
use Assetic\Asset\AssetCollection;
use Assetic\Cache\FilesystemCache;

class TemplatingProvider implements ServiceProviderInterface
{
    public function register(SilexApp $app)
    {
        $app->register(new TwigServiceProvider());
        $app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
            $twig->addFilter(new \Twig_SimpleFilter('grid', 'App\Twig\GridFilter::getClass'));

            return $twig;
        }));

        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new AsseticServiceProvider());

        $app['assetic.filter_manager'] = $app->share($app->extend('assetic.filter_manager', function($fm, $app) {
            $fm->set('yui_css', new CssCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('yui_js', new JsCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('lessphp', new LessphpFilter());
            return $fm;
        }));

        $app['assetic.asset_manager'] = $app->share($app->extend('assetic.asset_manager', function($am, $app) {
            $fm = $app['assetic.filter_manager'];

            $am->set('bootstrap_css', new AssetCache(
                new FileAsset($app['twbs_dir'] . '/less/bootstrap.less', [$fm->get('lessphp')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('bootstrap_css')->setTargetPath('assets/css/bootstrap.css');

            $am->set('bootstrap_js', new AssetCache(
                new AssetCollection([
                    new FileAsset($app['twbs_dir'] . '/js/affix.js'),
                    new FileAsset($app['twbs_dir'] . '/js/alert.js'),
                    new FileAsset($app['twbs_dir'] . '/js/button.js'),
                    new FileAsset($app['twbs_dir'] . '/js/carousel.js'),
                    new FileAsset($app['twbs_dir'] . '/js/collapse.js'),
                    new FileAsset($app['twbs_dir'] . '/js/dropdown.js'),
                    new FileAsset($app['twbs_dir'] . '/js/modal.js'),
                    new FileAsset($app['twbs_dir'] . '/js/scrollspy.js'),
                    new FileAsset($app['twbs_dir'] . '/js/tab.js'),
                    new FileAsset($app['twbs_dir'] . '/js/tooltip.js'),
                    new FileAsset($app['twbs_dir'] . '/js/popover.js'),
                    new FileAsset($app['twbs_dir'] . '/js/transition.js'),
                ]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('bootstrap_js')->setTargetPath('assets/js/bootstrap.js');

            $am->set('custom_css', new AssetCache(
                new FileAsset($app['assets_dir'] . '/less/custom.less', [$fm->get('lessphp')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_css')->setTargetPath('assets/css/custom.css');

            $am->set('custom_js', new AssetCache(
                new GlobAsset($app['assets_dir'] . '/js/*.js'),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_js')->setTargetPath('assets/js/custom.js');

            return $am;
        }));

    }

    public function boot(SilexApp $app)
    {

    }
}
