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
    $app = require __DIR__ . '/../../../../src/app.php';

    return $app;
}

/**
 * Serialize merchants into array
 */
function serialize_merchants(\App\Popshops\MerchantCollection $merchants)
{
    return array_values($merchants->map(function (\App\Popshops\Merchant $merchant) {
        return [
            'id' => $merchant->getId(),
            'name' => $merchant->getName(),
            'logo' => $merchant->getLogoUrl(),
            'logo_thumb' => $merchant->getLogoUrl(),
            'description' => '',
            'cashback_percent' => 0,
            'cashback_flat' => 0,
            'cashback_text' => '0%',
            'coupons' => $merchant->getDealCount(),
            'link' => '/transfer/store/' . $merchant->getId(),
        ];
    })->toArray());
}

/**
 * Serialize deals into array
 */
function serialize_deals(\App\Popshops\DealCollection $deals)
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
        ];
    })->toArray());
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
