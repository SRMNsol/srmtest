<?php
/**
 * Bridge between CI front end and new popshops backend.
 * The legacy CI app is located under the root of the new backend.
 */

use Doctrine\Common\Collections\Collection;
use App\Entity\Rate;
use App\Entity\Subid;
use Popshops\Merchant;
use Popshops\Product;
use Popshops\Deal;
use Popshops\MerchantType;
use Popshops\Brand;
use Popshops\ProductSearchResult;

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
 *
 */
function create_subid($userId)
{
    $subid = new Subid();
    $subid->setUserId($userId);

    return $subid;
}

/**
 * Serialize merchants into array
 */
function result_merchants(Collection $merchants, Rate $rate, Subid $subid)
{
    return array_values($merchants->map(function (Merchant $merchant) use ($rate, $subid) {
        return [
            'id' => $merchant->getId(),
            'name' => $merchant->getName(),
            'logo' => $merchant->getLogoUrl(),
            'logo_thumb' => $merchant->getLogoUrl(),
            'description' => $merchant->getDescription(),
            'description-abrv' => truncate_str($merchant->getDescription()),
            'cashback_percent' => $merchant->getCommissionSharePercentage($rate->getLevel0() * 100),
            'cashback_flat' => $merchant->getCommissionShareFixed($rate->getLevel0() * 100),
            'cashback_text' => $merchant->getCommissionShareText($rate->getLevel0() * 100),
            'coupons' => $merchant->getDealCount(),
            'link' => '/transfer/store/' . $merchant->getId(),
            'url' => $merchant->getTrackingUrl($subid),
        ];
    })->toArray());
}

/**
 * serialize merchant types to array
 */
function result_merchant_types(Collection $merchantTypes)
{
    return array_values($merchantTypes->map(function (MerchantType $merchantType) {
        return [
            'id' => $merchantType->getId(),
            'name' => $merchantType->getName(),
            'count' => $merchantType->getProductCount(),
        ];
    })->toArray());
}

/**
 * Serialize deals into array
 */
function result_deals(Collection $deals, Rate $rate, Subid $subid)
{
    return array_values($deals->map(function (Deal $deal) use ($rate, $subid) {
        $merchant = $deal->getMerchant();

        return [
            'id' => $deal->getId(),
            'cid' => $deal->getId() . '-' . ($merchant ? $merchant->getId() : 0),
            'merchant_id' => $merchant ? $merchant->getId() : null,
            'name' => $deal->getName(),
            'code' => $deal->getCode(),
            'link' => '/transfer/coupon/' . $deal->getId() . '-' . ($merchant ? $merchant->getId() : 0),
            'cashback_flat' => $merchant ? $merchant->getCommissionShareFixed($rate->getLevel0() * 100) : null,
            'cashback_percent' => $merchant ? $merchant->getCommissionSharePercentage($rate->getLevel0() * 100) : null,
            'logo' => $merchant ? $merchant->getLogoUrl() : null,
            'logo_thumb' => $merchant ? $merchant->getLogoUrl() : null,
            'merchant_name' => $merchant ? $merchant->getName() : null,
            'merchant_logo' => $merchant ? $merchant->getLogoUrl() : null,
            'end_date' => $deal->getEndOn()->format('m/d/Y'),
            'restrictions' => $deal->getDescription(),
            'code_prefix' => $deal->getCode() ? 'Coupon: ' : '',
            'cashback_text' => $merchant ? $merchant->getCommissionShareText($rate->getLevel0() * 100) : null,
            'linkstore' => '/stores/details/' . ($merchant ? $merchant->getId() : null),
            'name-abrv' => truncate_str($deal->getName()),
            'exp_date_short' => $deal->getEndOn() < new \DateTime('1 month') ? $deal->getEndOn()->diff(new DateTime())->format('Expires in %a days') : '',
            'expiration' => $deal->getEndOn()->format('M d, Y'),
            'url' => $deal->getTrackingUrl($subid),
        ];
    })->toArray());
}

/**
 * serialize products to array
 */
function result_products(Collection $products)
{
    return array_values($products->map(function (Product $product) {
        return [
            'id' => $product->getId(),
            'groupID' => $product->getGroupId(),
            'name' => $product->getName(),
            'name-abrv' => truncate_str($product->getName(), 100),
            'description' => $product->getDescription(),
            'description-abrv' => truncate_str($product->getDescription(), 100),
            'category_id' => null,
            'category_name' => null,
            'parent_category_id' => null,
            'parent_category_name' => null,
            'grandparent_category_name' => null,
            'grandparent_category_id' => null,
            'lowprice' => $product->getLowestPrice() ,
            'numchildproducts' => $product->getMerchantCount(),
            'sales_rank' => 0,
            'score' => 0,
            'image' => $product->getLargeImageUrl(),
        ];
    })->toArray());
}

/**
 * serialize brands to array
 */
function result_brands(Collection $brands)
{
    return array_values($brands->map(function (Brand $brand) {
        return [
            'id' => $brand->getId(),
            'name' => $brand->getName(),
            'count' => $brand->getProductCount(),
        ];
    })->toArray());
}

/**
 * build comparison result
 */
function comparison_result(ProductSearchResult $result, Rate $rate, Subid $subid)
{
    $comparison = [];
    foreach ($result->getProducts() as $product) {
        $deal = $result->getDeals()->filter(function (Deal $deal) use ($product) {
            return $deal->getMerchant() === $product->getMerchant();
        })->current();

        $comparison[] = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'parent_id' => null,
            'brand' => $product->getBrand() ? $product->getBrand()->getName() : null,
            'description' => $product->getDescription(),
            'manufacturer_model' => null,
            'upc' => null,
            'sku' => null,
            'availability' => null,
            'condition' => null,
            'group_id' => $product->getGroupId(),
            'product_url' => $product->getUrl(),
            'retail_amount' => number_format($product->getRetailPrice(), 2),
            'cashback_amount' => number_format($product->calculateCommissionShareAmount($rate->getLevel0() * 100), 2),
            'final_amount' => number_format($product->calculateFinalPrice($rate->getLevel0() * 100), 2),
            'cashback_amount_half' => 0,
            'final_amount_half' => $product->getMerchantPrice() - 0,
            'merchant_id' => $product->getMerchant() ? $product->getMerchant()->getId() : null,
            'merchant_name' => $product->getMerchant() ? $product->getMerchant()->getName() : null,
            'merchant_image' => $product->getMerchant() ? $product->getMerchant()->getLogoUrl() : null,
            'shipping_amount' => null,
            'tax_amount' => null,
            't&s' => null,
            'coupon_discount' => $deal ? $deal->getName() : null,
            'coupon_id' => $deal ? $deal->getName() : null,
            'code' => $deal ? $deal->getCode() : null,
            'expiration' => $deal ? $deal->getEndOn()->format('M d,Y') : null,
            'image' => $product->getLargeImageUrl(),
            'thumb' => $product->getLargeImageUrl(),
            'link' => '/transfer/product/' . ($product->getGroupId() ?: '0' . $product->getId()) . '-' . $product->getId(),
            'url' => $product->getTrackingUrl($subid),
        ];
    }

    $comparison[0]['lowest_price'] = $result->getLowestPrice();
    $comparison[0]['highest_price'] = $result->getHighestPrice();
    $comparison[0]['lowest_price_half'] = $result->getLowestPrice();
    $comparison[0]['highest_price_half'] = $result->getHighestPrice();
    $comparison[0]['num_child_products'] = $result->getMerchants()->count();

    return $comparison;
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
