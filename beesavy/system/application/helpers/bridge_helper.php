<?php
/**
 * Bridge between CI front end and new popshops backend.
 * The legacy CI app is located under the root of the new backend.
 */

/**
 * Silex container loader
 */
function silex()
{
    static $app;

    if (!isset($app)) {
        $app = require __DIR__ . '/../../../../src/app.php';
    }

    return $app;
}

/**
 * Serialize merchants into array
 */
function serialize_merchants(\Doctrine\Common\Collections\Collection $merchants)
{
    return array_values($merchants->map(function (\App\Popshops\Merchant $merchant) {
        return [
            'id' => $merchant->getId(),
            'name' => $merchant->getName(),
            'logo' => $merchant->getLogoUrl(),
            'logo_thumb' => $merchant->getLogoUrl(),
            'description' => '',
            'description-abrv' => '',
            'cashback_percent' => 0,
            'cashback_flat' => 0,
            'cashback_text' => '0%',
            'coupons' => $merchant->getDealCount(),
            'link' => '/transfer/store/' . $merchant->getId(),
            'url' => $merchant->getUrl(),
        ];
    })->toArray());
}

/**
 * serialize merchant types to array
 */
function serialize_merchant_types(Doctrine\Common\Collections\Collection $merchantTypes)
{
    return array_values($merchantTypes->map(function (App\Popshops\MerchantType $merchantType) {
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
function serialize_deals(\Doctrine\Common\Collections\Collection $deals)
{
    return array_values($deals->map(function (\App\Popshops\Deal $deal) {
        return [
            'id' => null,
            'cid' => null,
            'merchant_id' => $deal->getMerchant()->getId(),
            'name' => $deal->getName(),
            'code' => $deal->getCode(),
            'link' => '/transfer/coupon/' . $deal->getUrl(),
            'cashback_flat' => 0,
            'cashback_percent' => 0,
            'logo' => $deal->getMerchant()->getLogoUrl(),
            'logo_thumb' => $deal->getMerchant()->getLogoUrl(),
            'merchant_name' => $deal->getMerchant()->getName(),
            'merchant_logo' => $deal->getMerchant()->getLogoUrl(),
            'end_date' => $deal->getEndOn()->format('m/d/Y'),
            'restrictions' => $deal->getDescription(),
            'code_prefix' => 'Coupon: ',
            'cashback_text' => '0%',
            'linkstore' => '/stores/details/' . $deal->getMerchant()->getId(),
            'name-abrv' => truncate_str($deal->getName()),
            'exp_date_short' => $deal->getEndOn()->diff(new DateTime())->format('Expires in %a days'),
            'expiration' => $deal->getEndOn()->format('M d, Y'),
        ];
    })->toArray());
}

/**
 * serialize products to array
 */
function serialize_products(Doctrine\Common\Collections\Collection $products)
{
    return array_values($products->map(function (\App\Popshops\Product $product) {
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
            'url' => $product->getUrl(),
            'link' => '/transfer/product/' . ($product->getGroupId() ?: '0' . $product->getId()) . '-' . $product->getId(),
            'merchant_id' => $product->getMerchant() ? $product->getMerchant()->getId() : null,
            'merchant_name' => $product->getMerchant() ? $product->getMerchant()->getName() : null,
        ];
    })->toArray());
}

/**
 * serialize brands to array
 */
function serialize_brands(\Doctrine\Common\Collections\Collection $brands)
{
    return array_values($brands->map(function (\App\Popshops\Brand $brand) {
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
function comparison_result(\App\Popshops\ProductSearchResult $result)
{
    $comparison = [];
    foreach ($result->getProducts() as $product) {
        $deal = $result->getDeals()->filter(function (\App\Popshops\Deal $deal) use ($product) {
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
            'retail_amount' => $product->getRetailPrice(),
            'cashback_amount' => 0,
            'final_amount' => $product->getMerchantPrice() - 0,
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
