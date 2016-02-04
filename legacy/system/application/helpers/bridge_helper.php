<?php
/**
 * Bridge between CI front end and new backend.
 * The legacy CI app is located under the root of the new backend.
 */

use Doctrine\Common\Collections\Collection;
use App\Entity\Rate;
use App\Entity\Subid;
use App\Entity\Merchant;
use App\Entity\Category;

/**
 * Silex container loader
 */
function silex()
{
    static $app;

    if (!isset($app)) {
        $app = require __DIR__ . '/../../../../src/app.php';
        $app->boot();
    }

    return $app;
}

/**
 * Create subid
 */
function create_subid($userId)
{
    $subid = new Subid();
    $subid->setUserId($userId);
    $subid->setTimestamp(new DateTime());

    return $subid;
}

/**
 * Serialize merchants into array
 */
function result_merchants($merchants, Rate $rate, Subid $subid = null)
{
    return array_map(function (Merchant $merchant) use ($rate, $subid) {
        return [
            'id' => $merchant->getId(),
            'name' => $merchant->getDisplayName(),
            'logo' => s3rotate($merchant->getLogoWebUrl()),
            'logo_thumb' => s3rotate($merchant->getLogoWebUrl()),
            'description' => $merchant->getDescription(),
            'description-abrv' => truncate_str($merchant->getDescription(), 65),
            'cashback_percent' => $merchant->getCommissionSharePercentage($rate->getLevel0() * 100),
            'cashback_flat' => $merchant->getCommissionShareFixed($rate->getLevel0() * 100),
            'cashback_text' => $merchant->getCommissionShareText($rate->getLevel0() * 100, '$', 'Up to :max'),
            'coupons' => 0,
            'link' => '/transfer/store/' . $merchant->getId(),
            'url' => $merchant->getTrackingUrl($subid),
        ];
    }, $merchants instanceof Collection ? $merchants->getValues() : (array) $merchants);
}

/**
 * serialize categories to array
 */
function result_categories($categories)
{
    return array_map(function (Category $category) {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];
    }, (array) $categories);
}

/**
 * cached categories
 */
function cached_categories()
{
    $container = silex();
    $cache = $container['cache.default_storage'];
    $key = 'WWW_CATEGORIES';
    if ($cache->contains($key)) {
        return $cache->fetch($key);
    }
    $categories = result_categories($container['orm.em']->getRepository('App\Entity\Category')->findBy([], ['name' => 'ASC']));
    $cache->save($key, $categories, 3600);
    return $categories;
}

/**
 * Random slice array
 */
function random_slice(array $array, $length)
{
    shuffle($array);
    return array_slice($array, 0, $length);
}

/**
 * Truncate nicely a string
 */
function truncate_str($str, $length = 20)
{
    if (strlen($str) > $length) {
        return substr($str, 0, $length - 3) . '...';
    }
    return $str;
}

/**
 * Filter merchants by name
 */
function merchants_filter_prefix(array $merchants, $prefix)
{
    return array_filter($merchants, function ($merchant) use ($prefix) {
        $pattern = ($prefix === '*') ? '\d' : preg_quote($prefix);
        if (preg_match("/^$pattern/i", $merchant->getName())) {
            return $merchant;
        }
    });
}
